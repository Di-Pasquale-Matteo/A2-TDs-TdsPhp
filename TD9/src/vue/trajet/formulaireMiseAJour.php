<?php
/** @var Trajet $trajet */
$idHTML = htmlspecialchars($trajet->getId());
$departHTML = htmlspecialchars($trajet->getDepart());
$arriveeHTML = htmlspecialchars($trajet->getArrivee());
$dateHTML = htmlspecialchars($trajet->getDate()->format('Y-m-d'));
$prixHTML = htmlspecialchars($trajet->getPrix());
$conducteurLoginHTML = htmlspecialchars($trajet->getConducteur()->getLogin());
?>

<body>
<form method="get" action="controleurFrontal.php">
    <!-- Remplacer method="get" par method="post" pour changer le format d'envoi des données -->
    <fieldset>
        <legend>Mon formulaire :</legend>
        <p>
            <label for="depart_id">Depart</label> :
            <input type="text" placeholder="Raimon" name="depart" id="depart_id" value="<?= $departHTML ?>" required="">
        </p>
        <p>
            <label for="arrivee_id">Arrivée</label> :
            <input type="text" placeholder="Royal Academy" name="arrivee" id="arrivee_id" value="<?= $arriveeHTML ?>" required="">
        </p>
        <p>
            <label for="date_id">Date</label> :
            <input type="date" placeholder="JJ/MM/AAAA" name="date" id="date_id" value="<?= $dateHTML ?>" required="">
        </p>
        <p>
            <label for="prix_id">Prix</label> :
            <input type="number" placeholder="20" name="prix" id="prix_id" value="<?= $prixHTML ?>" required="">
        </p>
        <p>
            <label for="conducteurLogin_id">Login du conducteur</label> :
            <input type="text" placeholder="evansm" name="conducteurLogin" id="conducteurLogin_id" value="<?= $conducteurLoginHTML ?>" required="">
        </p>
        <p>
            <label for="nonFumeur_id">Non Fumeur ?</label> :
            <input type="checkbox" name="nonFumeur" id="nonFumeur_id" <?= $trajet->isNonFumeur() ? 'checked' : '' ?>>
        </p>
        <p>
            <input type="submit" value="Envoyer">
        </p>
        <input type='hidden' name="action" value="mettreAJour">
        <input type="hidden" name="controleur" value="trajet">
        <input type="hidden" name="id" value="<?= $idHTML ?>">
    </fieldset>
</form>
</body>
