<?php
namespace App\Covoiturage\Controleur;
use App\Covoiturage\Lib\ConnexionUtilisateur;
use App\Covoiturage\Lib\MessageFlash;
use App\Covoiturage\Lib\MotDePasse;
use App\Covoiturage\Lib\VerificationEmail;
use App\Covoiturage\Modele\ConnexionBaseDeDonnees;
use App\Covoiturage\Modele\HTTP\Session;
use App\Covoiturage\Modele\Repository\AbstractRepository;
use App\Covoiturage\Modele\Repository\UtilisateurRepository;
use App\Covoiturage\Modele\DataObject\Utilisateur;
use App\Covoiturage\Modele\HTTP\Cookie;

class ControleurUtilisateur extends ControleurGenerique {
    // Déclaration de type de retour void : la fonction ne retourne pas de valeur
    public static function afficherListe() : void {
        $utilisateurs = (new UtilisateurRepository())->recuperer(); //appel au modèle pour gérer la BD
        self::afficherVue('vueGenerale.php',["utilisateurs" => $utilisateurs,"titre"=>"Liste des utilisateurs", "cheminCorpsVue" => "utilisateur/liste.php"]);  //"redirige" vers la vue
    }

    public static function afficherDetail() : void {
        if (!isset($_REQUEST['login'])) {
            self::afficherErreur("Erreur de login");
        }
        else{
            $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($_REQUEST['login']);
            if ($utilisateur != NULL) {
                self::afficherVue('vueGenerale.php', ["utilisateur" => $utilisateur, "titre"=>"Detail des utilisateurs", "cheminCorpsVue" => "utilisateur/detail.php"]);
            }
            else{
                MessageFlash::ajouter("warning","Login inconnu");
                ControleurGenerique::redirectionVersURL("controleurFrontal.php?action=afficherListe");
            }
        }
    }

    public static function afficherFormulaireCreation() : void {
        self::afficherVue('vueGenerale.php',["titre"=>"Formulaire de création", "cheminCorpsVue" => "utilisateur/formulaireCreation.php"]);
    }

    public static function afficherFormulaireMiseAJour() : void {
        $login = $_REQUEST['login'];
        if (!ConnexionUtilisateur::estUtilisateur($login) && !ConnexionUtilisateur::estAdministrateur()) {
            self::afficherErreur("La mise à jour n’est possible que pour l’utilisateur connecté.");
            return;
        }
        if (ConnexionUtilisateur::estAdministrateur() && (new UtilisateurRepository())->recupererParClePrimaire($login) == null) {
            self::afficherErreur("Login inconnu");
            return;
        }
        $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($login);
        self::afficherVue('vueGenerale.php',["titre"=>"Formulaire de modification","utilisateur"=>$utilisateur, "cheminCorpsVue" => "utilisateur/formulaireMiseAJour.php"]);
    }

    public static function afficherErreur(string $messageErreur = "") : void {
        self::afficherVue('vueGenerale.php',["titre"=>"Erreur","messageErreur" => $messageErreur,"cheminCorpsVue" => "utilisateur/erreur.php"]);
    }

    public static function supprimer() : void {
        if (!isset($_REQUEST['login'])) {
            self::afficherErreur("Manque d'informations");
            return;
        }
        $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($_REQUEST['login']);
        if ($utilisateur == NULL) {
            self::afficherErreur("Login incorrect");
            return;
        }
        if (!ConnexionUtilisateur::estUtilisateur($utilisateur->getLogin())) {
            self::afficherErreur("La mise à jour n’est possible que pour l’utilisateur connecté.");
            return;
        }
        $login = $_REQUEST['login'];
        (new UtilisateurRepository)->supprimer($login);
        MessageFlash::ajouter("success","L'utilisateur a bien été supprimé");
        ControleurGenerique::redirectionVersURL("controleurFrontal.php?action:afficherListe");
        //  self::afficherVue('vueGenerale.php',["utilisateurs"=>$utilisateurs,"titre"=>"Liste des utilisateurs","login"=>$login,"cheminCorpsVue" => "utilisateur/utilisateurSupprime.php"]);
    }

    public static function creerDepuisFormulaire() : void {
        if ($_REQUEST['mdp'] = $_REQUEST['mdp2'])
        {
            $utilisateur = self::construireDepuisFormulaire($_REQUEST);
            if (!filter_var($utilisateur->getEmailAValider(), FILTER_VALIDATE_EMAIL)) {
                self::afficherErreur("Email invalide");
                return;
            }
            VerificationEmail::envoiEmailValidation($utilisateur);
            (new UtilisateurRepository)->ajouter($utilisateur);
            $utilisateurs = (new UtilisateurRepository)->recuperer();
            self::afficherVue('vueGenerale.php',["utilisateurs" => $utilisateurs, "titre"=>"Liste des utilisateurs", "cheminCorpsVue" => "utilisateur/utilisateurCree.php"]);
        }
        else{
            self::afficherErreur("Mots de passe distincts");
        }
    }

    public static function mettreAJour() : void {
        if (!ConnexionUtilisateur::estUtilisateur($_REQUEST['login']) && !ConnexionUtilisateur::estAdministrateur()) {
            self::afficherErreur("La mise à jour n’est possible que pour l’utilisateur connecté.");
            return;
        }
        if (!isset($_REQUEST['login']) || !isset($_REQUEST['prenom']) || !isset($_REQUEST['nom']) || !isset($_REQUEST['mdp']) || !isset($_REQUEST['mdp2'])) {
            self::afficherErreur("Manque d'informations");
            return;
        }
        if (!isset($_REQUEST['mdp0']) && !ConnexionUtilisateur::estAdministrateur()) {
            self::afficherErreur("Manque d'informations");
            return;
        }
        $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($_REQUEST['login']);
        if (ConnexionUtilisateur::estAdministrateur() && $utilisateur == null) {
            self::afficherErreur("Login inconnu");
            return;
        }
        if ($_REQUEST['mdp'] != $_REQUEST['mdp2']) {
            self::afficherErreur("Les mots de passe ne correspondent pas");
            return;
        }
        if (hash('sha256',$_REQUEST['mdp0']) != $utilisateur->getMdpHache()) {
            self::afficherErreur("Ancien mot de de passe incorrect");
            return;
        }
        if (!ConnexionUtilisateur::estUtilisateur($utilisateur->getLogin())) {
            self::afficherErreur("La mise à jour n’est possible que pour l’utilisateur connecté.");
            return;
        }
        //$utilisateur = self::construireDepuisFormulaire($_REQUEST);
        $utilisateur->setNom($_REQUEST['nom']);
        $utilisateur->setPrenom($_REQUEST['prenom']);
        $utilisateur->setMdpHache(hash('sha256',$_REQUEST['mdp']));
        if (ConnexionUtilisateur::estAdministrateur()) {
            $utilisateur->setEstAdmin($_REQUEST['estAdmin']);
        }
        if ($utilisateur->getEmail()!=$_REQUEST['email']) {
            $utilisateur->setEmailAValider($_REQUEST['email']);
            $utilisateur->setnonce(MotDePasse::genererChaineAleatoire());
            if (!filter_var($utilisateur->getEmailAValider(), FILTER_VALIDATE_EMAIL)) {
                self::afficherErreur("Email invalide");
                return;
            }
            if ($utilisateur instanceof Utilisateur) {
                VerificationEmail::envoiEmailValidation($utilisateur);
            }
        }
        (new UtilisateurRepository)->mettreAJour($utilisateur);
        $utilisateurs = (new UtilisateurRepository)->recuperer();
        self::afficherVue('vueGenerale.php',["utilisateurs"=>$utilisateurs,"titre"=>"Liste des utilisateurs","login"=>$utilisateur->getLogin(),"cheminCorpsVue" => "utilisateur/utilisateurMisAJour.php"]);
    }

    /**
     * @return Utilisateur
     */
    private static function construireDepuisFormulaire(array $tableauDonneesFormulaire): Utilisateur
    {
        $login = $tableauDonneesFormulaire['login'];
        $prenom = $tableauDonneesFormulaire['prenom'];
        $nom = $tableauDonneesFormulaire['nom'];
        $mdp = $tableauDonneesFormulaire['mdp'];
        $mdpHache = hash("sha256", $mdp);
        if (ConnexionUtilisateur::estAdministrateur() && isset($tableauDonneesFormulaire['estAdmin'])) {
            $estAdmin = 1;
        }
        else{
            $estAdmin = 0;
        }
        $email = "";
        $emailAValider = $tableauDonneesFormulaire['email'];
        $nonce = MotDePasse::genererChaineAleatoire();
        $utilisateur = new Utilisateur($login, $nom, $prenom,$mdpHache,$estAdmin,$email,$emailAValider,$nonce);
        return $utilisateur;
    }

    public static function afficherFormulaireConnexion() : void {
        self::afficherVue('vueGenerale.php',['titre'=>'Formulaire de connexion',"cheminCorpsVue" => "utilisateur/formulaireConnexion.php"]);
    }

    public static function connecter() : void {
        if (!isset($_REQUEST['login']) || !isset($_REQUEST['mdp'])) {
            self::afficherErreur("Login et/ou mot de passe manquant");
        }
        else{
            $login = $_REQUEST['login'];
            $mdp = $_REQUEST['mdp'];
            $utilisateur = (new UtilisateurRepository)->recupererParClePrimaire($login);
            if ($utilisateur == null || $utilisateur->getMdpHache() != hash("sha256", $mdp)) {
                self::afficherErreur("Login et/ou mot de passe incorrect");
            }
            else if (!$utilisateur instanceof Utilisateur) {
                self::afficherErreur("Ce n'est pas un utilisateur");
            }
            else if (!VerificationEmail::aValideEmail($utilisateur)) {
                self::afficherErreur("Email non validé");
            }
            else{
                ConnexionUtilisateur::connecter($login);
                self::afficherVue("vueGenerale.php",['titre'=>"Details de l'utilisateur", "login"=>$login,"utilisateur"=>$utilisateur, 'cheminCorpsVue' => "utilisateur/utilisateurConnecte.php"]);
            }
        }
    }

    public static function deconnecter() : void
    {
        ConnexionUtilisateur::deconnecter();
        $utilisateurs = (new UtilisateurRepository())->recuperer();
        self::afficherVue("vueGenerale.php",['utilisateurs'=>$utilisateurs,'titre'=>"Liste des utilisateurs",'cheminCorpsVue' => "utilisateur/utilisateurDeconnecte.php"]);
    }

    public static function validerEmail()
    {
        if (!isset($_REQUEST['login']) || !isset($_REQUEST['nonce'])) {
            self::afficherErreur("Login et/ou nonce manquant");
            return;
        }
        $login = $_REQUEST['login'];
        $nonce = $_REQUEST['nonce'];
        if (!VerificationEmail::traiterEmailValidation($login,$nonce)){
            self::afficherErreur("Email invalide");
            return;
        }
        $utilisateur = (new UtilisateurRepository)->recupererParClePrimaire($login);
        self::afficherVue("VueGenerale.php", ["utilisateur" => $utilisateur, "titre"=>"Detail des utilisateurs", "cheminCorpsVue" => "utilisateur/detail.php"]);
    }

    /*
    public static function deposerCookie(): void
    {
        Cookie::enregistrer("testCookie2","OK");
    }

    public static function lireCookie(): void{
        echo(Cookie::lire("testCookie2"));
    }
    */

    /*public static function sessionTemp(){
        $session = Session::getInstance();
        $session->enregistrer("utilisateur",new Utilisateur("evansm","evans","marc"));
        echo($session->lire("utilisateur")->getNom());
        $session->supprimer("utilisateur");
        $session->detruire();
    }*/
}
?>
