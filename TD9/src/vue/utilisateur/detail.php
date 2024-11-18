<?php
/** @var Utilisateur $utilisateur */

use App\Covoiturage\Lib\ConnexionUtilisateur;

$prenomHTML = htmlspecialchars($utilisateur->getPrenom());
$nomHTML = htmlspecialchars($utilisateur->getNom());
$loginHTML = htmlspecialchars($utilisateur->getLogin());
$loginURL = rawurlencode($utilisateur->getLogin());
echo '<p>Utilisateur ' . $prenomHTML . " " . $nomHTML . ' de login ' . $loginHTML;
if (ConnexionUtilisateur::estUtilisateur($utilisateur->getLogin())) {
    echo '| <a href=controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireMiseAJour&login=' . $loginURL . '>Modifier</a>
 | <a href=controleurFrontal.php?controleur=utilisateur&action=supprimer&login=' . $loginURL . '>Supprmier</a>.</p>';
}
echo '</p>';
?>
