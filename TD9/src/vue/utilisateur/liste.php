<body>
<?php
/** @var ModeleUtilisateur[] $utilisateurs */
foreach ($utilisateurs as $utilisateur) {
    $loginHTML = htmlspecialchars($utilisateur->getLogin());
    $loginURL = rawurlencode($utilisateur->getLogin());
    echo '<p> Utilisateur de loginx <a href=controleurFrontal.php?controleur=utilisateur&action=afficherDetail&login=' . $loginURL . '> ' . $loginHTML . '</a>';
    if (\App\Covoiturage\Lib\ConnexionUtilisateur::estAdministrateur()){
        echo ' | <a href=controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireMiseAJour&login='.$loginURL.'>Modifier</a>
<!--| <a href=controleurFrontal.php?controleur=utilisateur&action=supprimer&login='.$loginURL.'>Supprmier</a> -->';
    }
    echo '</p>';
}
echo '<p> <a href = controleurFrontal.php?action=afficherFormulaireCreation>Créer un utilisateur</a>';
?>
</body>