<?php
namespace App\Covoiturage\Controleur;
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
        if (!isset($_GET['login'])) {
            self::afficherErreur("Erreur de login");
        }
        else{
            $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($_GET['login']);
            if ($utilisateur != NULL) {
                self::afficherVue('vueGenerale.php', ["utilisateur" => $utilisateur, "titre"=>"Detail des utilisateurs", "cheminCorpsVue" => "utilisateur/detail.php"]);
            }
            else{
                self::afficherErreur("Erreur de login");
            }
        }
    }

    public static function afficherFormulaireCreation() : void {
        self::afficherVue('vueGenerale.php',["titre"=>"Formulaire de création", "cheminCorpsVue" => "utilisateur/formulaireCreation.php"]);
    }

    public static function afficherFormulaireMiseAJour() : void {
        $login = $_GET['login'];
        $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($login);
        self::afficherVue('vueGenerale.php',["titre"=>"Formulaire de modification","utilisateur"=>$utilisateur, "cheminCorpsVue" => "utilisateur/formulaireMiseAJour.php"]);
    }

    public static function afficherErreur(string $messageErreur = "") : void {
        self::afficherVue('vueGenerale.php',["titre"=>"Erreur","messageErreur" => $messageErreur,"cheminCorpsVue" => "utilisateur/erreur.php"]);
    }

    public static function supprimer() : void {
        $login = $_GET['login'];
        (new UtilisateurRepository)->supprimer($login);
        $utilisateurs = (new UtilisateurRepository)->recuperer();
        self::afficherVue('vueGenerale.php',["utilisateurs"=>$utilisateurs,"titre"=>"Liste des utilisateurs","login"=>$login,"cheminCorpsVue" => "utilisateur/utilisateurSupprime.php"]);
    }

    public static function creerDepuisFormulaire() : void {
        $utilisateur = self::construireDepuisFormulaire($_GET);
        (new UtilisateurRepository)->ajouter($utilisateur);
        $utilisateurs = (new UtilisateurRepository)->recuperer();
        self::afficherVue('vueGenerale.php',["utilisateurs" => $utilisateurs, "titre"=>"Liste des utilisateurs", "cheminCorpsVue" => "utilisateur/utilisateurCree.php"]);
    }

    public static function mettreAJour() : void {
        $utilisateur = self::construireDepuisFormulaire($_GET);
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
        $utilisateur = new Utilisateur($login, $nom, $prenom);
        return $utilisateur;
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

    public static function sessionTemp(){
        $session = Session::getInstance();
        $session->enregistrer("utilisateur",new Utilisateur("evansm","evans","marc"));
        echo($session->lire("utilisateur")->getNom());
        $session->supprimer("utilisateur");
        $session->detruire();
    }
}
?>
