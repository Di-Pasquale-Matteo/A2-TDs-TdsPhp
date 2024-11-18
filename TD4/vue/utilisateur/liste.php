<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Liste des utilisateurs</title>
    </head>
    <body>
        <?php
        /** @var ModeleUtilisateur[] $utilisateurs */
        foreach ($utilisateurs as $utilisateur)
            echo '<p> Utilisateur de login  <a href=routeur.php?action=afficherDetail&login='.$utilisateur->getLogin() .'> '. $utilisateur->getLogin() .' </a>.</p>';
        echo  '<p> <a href = routeur.php?action=afficherFormulaireCreation>Créer un utilisateur</a>'
        ?>
    </body>
</html>