<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title> Mon premier php </title>
    </head>
    <body>
    <?php
    include_once 'Utilisateur.php';
        echo "Utilisateur $_GET[prenom] $_GET[nom] de login $_GET[login]<br>";
        $utilisateur = new Utilisateur($_GET['login'],$_GET['nom'],$_GET['prenom']);
        $utilisateur->ajouter();
    ?>
    </body>
</html>