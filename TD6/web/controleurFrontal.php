<?php
require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

use App\Covoiturage\Controleur\ControleurUtilisateur;

// initialisation en activant l'affichage de débogage
$chargeurDeClasse = new App\Covoiturage\Lib\Psr4AutoloaderClass(false);
$chargeurDeClasse->register();
// enregistrement d'une association "espace de nom" → "dossier"
$chargeurDeClasse->addNamespace('App\Covoiturage', __DIR__ . '/../src');

if (!isset($_GET['controleur'])) {
    $_GET['controleur'] = "utilisateur";
}

$controleur = $_GET['controleur'];
$nomDeClasseControlleur = "App\Covoiturage\Controleur\Controleur" . ucfirst($controleur);

if (!class_exists($nomDeClasseControlleur)){
    ControleurUtilisateur::afficherErreur("Classe non valide");
    echo $nomDeClasseControlleur;
}
else {
    if (!isset($_GET['action'])) {
        $_GET['action'] = "afficherListe";
    }
// On récupère l'action passée dans l'URL
    $action = $_GET['action'];
// Appel de la méthode statique $action de ControleurUtilisateur
    $methodes = get_class_methods("\App\Covoiturage\Controleur\ControleurUtilisateur");
    if (!in_array($action, $methodes)) {
        $nomDeClasseControlleur::afficherErreur("Action non valide");
    } else
        $nomDeClasseControlleur::$action();
}
?>
