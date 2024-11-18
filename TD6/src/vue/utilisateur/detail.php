<body>
<?php
/** @var Utilisateur $utilisateur */
$prenomHTML = htmlspecialchars($utilisateur->getPrenom());
$nomHTML = htmlspecialchars($utilisateur->getNom());
$loginHTML = htmlspecialchars($utilisateur->getLogin());
echo '<p>Utilisateur ' . $prenomHTML . " " . $nomHTML . ' de login ' . $loginHTML . '.</p>';
?>
</body>
