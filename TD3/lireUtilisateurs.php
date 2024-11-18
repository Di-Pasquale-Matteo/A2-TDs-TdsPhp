<?php

include_once 'ConnexionBaseDeDonnees.php';
include_once 'Utilisateur.php';

//var_dump($utilisateurFormatTableau);


$tableau = Utilisateur::recupererUtiilisateurs();

foreach($tableau as $row){
    echo $row;
}

?>
