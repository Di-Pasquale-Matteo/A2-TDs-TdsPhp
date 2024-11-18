<body>
<?php
/** @var ModeleUtilisateur[] $utilisateurs */
foreach ($utilisateurs as $utilisateur) {
    $loginHTML = htmlspecialchars($utilisateur->getLogin());
    $loginURL = rawurlencode($utilisateur->getLogin());
    echo '<p> Utilisateur de login  <a href=controleurFrontal.php?action=afficherDetail&login=' . $loginURL . '> ' . $loginHTML . ' </a>.</p>';
}
echo '<p> <a href = controleurFrontal.php?action=afficherFormulaireCreation>Créer un utilisateur</a>';
?>
</body>