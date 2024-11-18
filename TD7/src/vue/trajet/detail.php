<?php
/** @var Trajet $trajet */
$nonFumeur = $trajet->isNonFumeur() ? "non fumeur" : "";
$dateHTML = htmlspecialchars($trajet->getDate()->format('d/m/Y'));
$departHTML = htmlspecialchars($trajet->getDepart());
$arriveeHTML = htmlspecialchars($trajet->getArrivee());
$prenomHTML = htmlspecialchars($trajet->getConducteur()->getPrenom());
$nomHTML = htmlspecialchars($trajet->getConducteur()->getNom());
echo '<p>Le trajet ' . $nonFumeur . ' du '.$dateHTML.' partira de '.$departHTML.' pour aller à '.$arriveeHTML.' (conducteur : '.$prenomHTML.' '.$nomHTML.').';