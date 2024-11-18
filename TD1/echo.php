<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title> Mon premier php </title>
    </head>
   
    <body>
        <?php
            $prenom = "Marc";
            $nom = "Evans";
            $login = "evansm";

            //echo "Utilisateur $prenom $nom de login $login<br>";

            $utilisateur1 = [
                'prenom' => 'Shawn',
                'nom' => 'Frost',
                'login' => 'frosts'
            ];
            //echo "Utilisateur $utilisateur1[prenom] $utilisateur1[nom] de login $utilisateur1[login]<br>";

            $utilisateur2 = [
                'prenom' => 'Axel',
                'nom' => 'Blaze',
                'login' => 'blazea'
            ];

            $utilisateurs = [$utilisateur1, $utilisateur2];
            if (empty($utilisateurs)){
                echo "Il n’y a aucun utilisateur.";
            }
            else{
                foreach ($utilisateurs as $utilisateur) {
                    echo "Utilisateur $utilisateur[prenom] $utilisateur[nom] de login $utilisateur[login]<br>";
                }
            }
        ?>
    </body>
</html>
