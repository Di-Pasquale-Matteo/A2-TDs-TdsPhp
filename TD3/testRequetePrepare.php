<?php

include_once 'Utilisateur.php';

//$utilisateur = new Utilisateur('swiftn','Swift','Nathan');
//$utilisateur->ajouter();

$tableau = Utilisateur::recupererUtiilisateurs();
foreach ($tableau as $td) {
    echo Utilisateur::recupererUtilisateurParLogin($td->getLogin());
}
echo Utilisateur::recupererUtilisateurParLogin('evansm');



?>