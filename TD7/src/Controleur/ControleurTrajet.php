<?php
namespace App\Covoiturage\Controleur;
use App\Covoiturage\Modele\DataObject\Trajet;
use App\Covoiturage\Modele\DataObject\Utilisateur;
use App\Covoiturage\Modele\Repository\AbstractRepository;
use App\Covoiturage\Modele\Repository\TrajetRepository;
use App\Covoiturage\Modele\Repository\UtilisateurRepository;
use DateTime;

class ControleurTrajet extends ControleurGenerique {

    public static function afficherListe() : void {
        $trajets = (new TrajetRepository())->recuperer(); //appel au modèle pour gérer la BD
        self::afficherVue('vueGenerale.php',["trajets" => $trajets,"titre"=>"Liste des trajets", "cheminCorpsVue" => "trajet/liste.php"]);  //"redirige" vers la vue
    }

    public static function afficherDetail() : void {
        if (!isset($_GET['id'])) {
            self::afficherErreur("Erreur de login");
        }
        else{
            $trajet = (new TrajetRepository())->recupererParClePrimaire($_GET['id']);
            if ($trajet != NULL) {
                self::afficherVue('vueGenerale.php', ["trajet" => $trajet, "titre"=>"Detail des trajets", "cheminCorpsVue" => "trajet/detail.php"]);
            }
            else{
                self::afficherErreur("Erreur de login");
            }
        }
    }

    public static function afficherErreur(string $messageErreur = "") : void {
        self::afficherVue('vueGenerale.php',["titre"=>"Erreur","messageErreur" => $messageErreur,"cheminCorpsVue" => "trajet/erreur.php"]);
    }

    public static function supprimer() : void {
        $id = $_GET['id'];
        (new TrajetRepository)->supprimer($id);
        $trajets = (new TrajetRepository)->recuperer();
        self::afficherVue('vueGenerale.php',["trajets"=>$trajets,"titre"=>"Liste des utilisateurs","id"=>$id,"cheminCorpsVue" => "trajet/trajetSupprime.php"]);
    }

    public static function afficherFormulaireCreation() : void {
        self::afficherVue('vueGenerale.php',["titre"=>"Formulaire de création", "cheminCorpsVue" => "trajet/formulaireCreation.php"]);
    }

    public static function afficherFormulaireMiseAjour() : void
    {
        $id = $_GET['id'];
        $trajet = (new TrajetRepository())->recupererParClePrimaire($id);
        self::afficherVue('vueGenerale.php',["titre"=>"Formulaire de modification","trajet"=>$trajet, "cheminCorpsVue" => "trajet/formulaireMiseAJour.php"]);

    }

    public static function creerDepuisFormulaire() : void {
        $trajet = self::construireDepuisFormulaire($_GET);
        (new TrajetRepository())->ajouter($trajet);
        $trajets = (new TrajetRepository)->recuperer();
        self::afficherVue('vueGenerale.php',["trajets" => $trajets, "titre"=>"Liste des trajets", "cheminCorpsVue" => "trajet/trajetCree.php"]);
    }

    public static function mettreAJour() : void {
        $trajet = self::construireDepuisFormulaire($_GET);
        (new TrajetRepository())->mettreAJour($trajet);
        $trajets = (new TrajetRepository())->recuperer();
        self::afficherVue('vueGenerale.php',["trajets"=>$trajets,"titre"=>"Liste des trajets","id"=>$trajet->getId() ,"cheminCorpsVue" => "trajet/trajetMisAJour.php"]);
    }

    /**
     * @return Trajet
     * @throws \DateMalformedStringException
     */
    private static function construireDepuisFormulaire(array $tableauDonneesFormulaire): Trajet
    {
        $id = $tableauDonneesFormulaire["id"] ?? null;
        $depart = $tableauDonneesFormulaire['depart'];
        $arrivee = $tableauDonneesFormulaire['arrivee'];
        $date = new DateTime($tableauDonneesFormulaire['date']);
        $prix = $tableauDonneesFormulaire['prix'];
        $conducteur = (new UtilisateurRepository)->recupererParClePrimaire($tableauDonneesFormulaire['conducteurLogin']);
        $nonFumeur = isset($tableauDonneesFormulaire["nonFumeur"]);
        $trajet = new Trajet(null, $depart, $arrivee, $date, $prix, $conducteur, $nonFumeur);
        return $trajet;
    }
}