<body>
<?php
/** @var Trajet[] $trajets */
foreach ($trajets as $trajet) {
    $idHTML = htmlspecialchars($trajet->getId());
    $idURL = rawurlencode($trajet->getId());
    echo '<p> Trajet d\'ID <a href=controleurFrontal.php?controleur=trajet&action=afficherDetail&id=' . $idURL . '> ' . $idHTML . '</a> 
 | <a href=controleurFrontal.php?controleur=trajet&action=afficherFormulaireMiseAJour&id='.$idURL.'>Modifier</a>
 | <a href=controleurFrontal.php?controleur=trajet&action=supprimer&id='. $idURL .'>Supprmier</a></p>';
}
echo '<p> <a href = controleurFrontal.php?controleur=trajet&action=afficherFormulaireCreation>Créer un trajet</a>';
?>
</body>