<?php
require_once ('../Modele/ModeleUtilisateur.php'); // chargement du modèle
class ControleurUtilisateur {
    // Déclaration de type de retour void : la fonction ne retourne pas de valeur
    public static function afficherListe() : void {
        $utilisateurs = ModeleUtilisateur::recupererUtilisateurs(); //appel au modèle pour gérer la BD
        self::afficherVue('utilisateur/liste.php',["utilisateurs" => $utilisateurs]);  //"redirige" vers la vue
    }

    public static function afficherDetail() : void {
        if (!isset($_GET['login'])) {
            self::afficherVue('utilisateur/erreur.php');
        }
        else{
            $utilisateur = ModeleUtilisateur::recupererUtilisateurParLogin($_GET['login']);
            if ($utilisateur != NULL) {
                self::afficherVue('utilisateur/detail.php', ["utilisateur" => $utilisateur]);
            }
            else{
                self::afficherVue('utilisateur/erreur.php');
            }
        }
    }

    public static function afficherFormulaireCreation() : void {
        self::afficherVue('utilisateur/formulaireCreation.php');
    }

    private static function afficherVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require "../vue/$cheminVue"; // Charge la vue
    }

    public static function creerDepuisFormulaire() : void {
        $login = $_GET['login'];
        $prenom = $_GET['prenom'];
        $nom = $_GET['nom'];
        $utilisateur = new ModeleUtilisateur($login, $prenom, $nom);
        $utilisateur->ajouter();
        self::afficherListe();
    }
}
?>
