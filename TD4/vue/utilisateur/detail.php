<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Detail des utilisateurs</title>
</head>
<body>
<?php
/** @var ModeleUtilisateur $utilisateur */
    echo'<p>Utilisateur '. $utilisateur->getPrenom() . " ". $utilisateur->getNom() .' de login '.$utilisateur->getLogin().'.</p>';
?>
</body>
</html>