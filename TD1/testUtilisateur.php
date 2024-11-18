<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title> Mon premier php </title>
    </head>

    <body>
        <?php
            require_once 'Utilisateur.php';
            $utilisateur1 = new Utilisateur("fosterx","Foster","Xavier");
            echo $utilisateur1;
        ?>
    </body>
</html>
