<?php
/** @var App\Covoiturage\Modele\DataObject\Utilisateur $utilisateur */
$prenomHTML = htmlspecialchars($utilisateur->getPrenom());
$nomHTML = htmlspecialchars($utilisateur->getNom());
$loginHTML = htmlspecialchars($utilisateur->getLogin());
$emailHTML = htmlspecialchars($utilisateur->getEmail());
?>

<body>
<form method=<?php echo \App\Covoiturage\Configuration\ConfigurationSite::getDebug()?"get":"post"; ?> action="controleurFrontal.php">
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
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mdp0_id">Ancient mot de passe&#42;</label>
            <input class="InputAddOn-field" type="password" value="" placeholder="" name="mdp0" id="mdp0_id" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mdp_id">Nouveau mot de passe&#42;</label>
            <input class="InputAddOn-field" type="password" value="" placeholder="" name="mdp" id="mdp_id" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mdp2_id">Vérification du mot de passe&#42;</label>
            <input class="InputAddOn-field" type="password" value="" placeholder="" name="mdp2" id="mdp2_id" required>
        </p>
        <?php if (\App\Covoiturage\Lib\ConnexionUtilisateur::estAdministrateur()){
            echo '
            <p class="InputAddOn">
            <label class="InputAddOn-item" for="estAdmin_id">Administrateur</label>
            <input class="InputAddOn-field" type="checkbox" placeholder="" name="estAdmin" id="estAdmin_id"';
            if ($utilisateur->isEstAdmin()) echo " checked";
            echo '>
            </p>';
        }?>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="email_id">Emaill&#42;</label>
            <input class="InputAddOn-field" type="text" placeholder="Ex : evans@raimon.jp" name="email" id="email_id" value="<?= $emailHTML ?>" required>
        </p>
        <p>
            <input type="submit" value="Envoyer" />
        </p>
        <input type='hidden' name='controleur' value='utilisateur'>
        <input type='hidden' name='action' value='mettreAJour'>
    </fieldset>
</form>
</body>