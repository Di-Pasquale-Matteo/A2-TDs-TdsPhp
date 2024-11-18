<?php
namespace App\Covoiturage\Controleur;

use App\Covoiturage\Lib\PreferenceControleur;

class ControleurGenerique{

    protected static function afficherVue(string $cheminVue, array $parametres = []): void
    {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../vue/$cheminVue"; // Charge la vue
    }

    public static function afficherFormulairePreference(): void{
        self::afficherVue("vueGenerale.php",["cheminCorpsVue"=>"formulairePreference.php"]);
    }

    public static function enregistrerPreference(): void{
        $controleurDefaut = $_REQUEST["controleur_defaut"];
        PreferenceControleur::enregistrer($controleurDefaut);
        self::afficherVue("vueGenerale.php",["cheminCorpsVue"=>"preferenceEnregistree.php"]);
    }
}
