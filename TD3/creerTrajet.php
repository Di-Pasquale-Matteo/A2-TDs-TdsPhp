<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title> Mon premier php </title>
    </head>
    <body>
        <?php
            include_once 'Trajet.php';
            $trajet = new Trajet(null,$_GET['depart'],$_GET['arrivee'],new DateTime($_GET['date']),$_GET['prix']
                ,Utilisateur::recupererUtilisateurParLogin($_GET['conducteurLogin']),isset($_GET["nonFumeur"]));
            $trajet->ajouter();
        ?>
    </body>
</html>