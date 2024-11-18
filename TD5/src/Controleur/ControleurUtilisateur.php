<?php
namespace App\Covoiturage\Controleur;
use App\Covoiturage\Modele\ConnexionBaseDeDonnees;
use App\Covoiturage\Modele\Utilisateur;

class ControleurUtilisateur {
    // Déclaration de type de retour void : la fonction ne retourne pas de valeur
    public static function afficherListe() : void {
        $utilisateurs = Utilisateur::recupererUtilisateurs(); //appel au modèle pour gérer la BD
        self::afficherVue('vueGenerale.php',["utilisateurs" => $utilisateurs,"titre"=>"Liste des utilisateurs", "cheminCorpsVue" => "utilisateur/liste.php"]);  //"redirige" vers la vue
    }

    public static function afficherDetail() : void {
        if (!isset($_GET['login'])) {
            self::afficherVue('vueGenerale.php',["titre"=>"Erreur de login","cheminCorpsVue" => "utilisateur/erreurlogin.php"]);
        }
        else{
            $utilisateur = Utilisateur::recupererUtilisateurParLogin($_GET['login']);
            if ($utilisateur != NULL) {
                self::afficherVue('vueGenerale.php', ["utilisateur" => $utilisateur, "titre"=>"Detail des utilisateurs", "cheminCorpsVue" => "utilisateur/detail.php"]);
            }
            else{
                self::afficherVue('vueGenerale.php',["titre"=>"Erreur de login","cheminCorpsVue" => "utilisateur/erreurlogin.php"]);
            }
        }
    }

    public static function afficherFormulaireCreation() : void {
        self::afficherVue('vueGenerale.php',["titre"=>"Formulaire de création", "cheminCorpsVue" => "utilisateur/formulaireCreation.php"]);
    }

    private static function afficherVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../vue/$cheminVue"; // Charge la vue
    }

    public static function creerDepuisFormulaire() : void {
        $login = $_GET['login'];
        $prenom = $_GET['prenom'];
        $nom = $_GET['nom'];
        $utilisateur = new Utilisateur($login, $prenom, $nom);
        $utilisateur->ajouter();
        $utilisateurs = Utilisateur::recupererUtilisateurs();
        self::afficherVue('vueGenerale.php',["utilisateurs" => $utilisateurs, "titre"=>"Liste des utilisateurs", "cheminCorpsVue" => "utilisateur/utilisateurCree.php"]);
    }
}
?>
