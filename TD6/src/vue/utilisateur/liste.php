<body>
<?php
/** @var ModeleUtilisateur[] $utilisateurs */
foreach ($utilisateurs as $utilisateur) {
    $loginHTML = htmlspecialchars($utilisateur->getLogin());
    $loginURL = rawurlencode($utilisateur->getLogin());
    echo '<p> Utilisateur de loginx <a href=controleurFrontal.php?action=afficherDetail&login=' . $loginURL . '> ' . $loginHTML . '</a>
 | <a href=controleurFrontal.php?action=afficherFormulaireMiseAJour&login='.$loginURL.'>Modifier</a>
 | <a href=controleurFrontal.php?action=supprimer&login='.$loginURL.'>Supprmier</a></p>';
}
echo '<p> <a href = controleurFrontal.php?action=afficherFormulaireCreation>Créer un utilisateur</a>';
?>
</body>