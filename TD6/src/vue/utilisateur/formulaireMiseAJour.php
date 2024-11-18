<?php
/** @var Utilisateur $utilisateur */
$prenomHTML = htmlspecialchars($utilisateur->getPrenom());
$nomHTML = htmlspecialchars($utilisateur->getNom());
$loginHTML = htmlspecialchars($utilisateur->getLogin());
?>

<body>
<form method="get" action="controleurFrontal.php">
    <fieldset>
        <legend>Mon formulaire :</legend>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="login_id">Login&#42;</label>
            <input class="InputAddOn-field" type="text" placeholder="Ex : evansm" name="login" id="login_id" value="<?= $loginHTML ?>" readonly required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="prenom_id">Prenom&#42;</label>
            <input class="InputAddOn-field" type="text" placeholder="Ex : Marc" name="prenom" id="prenom_id" value="<?= $prenomHTML ?>" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="nom_id">Nom&#42;</label>
            <input class="InputAddOn-field" type="text" placeholder="Ex : Evans" name="nom" id="nom_id" value="<?= $nomHTML ?>" required>
        </p>
        <p>
            <input type="submit" value="Envoyer" />
        </p>
        <input type='hidden' name='action' value='mettreAJour'>
    </fieldset>
</form>
</body>