<form method=<?php echo \App\Covoiturage\Configuration\ConfigurationSite::getDebug()?"get":"post"; ?> action="controleurFrontal.php">
    <fieldset>
        <legend>Mon formulaire :</legend>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="login_id">Login&#42;</label>
            <input class="InputAddOn-field" type="text" placeholder="Ex : evansm" name="login" id="login_id" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mdp_id">Mot de passe&#42;</label>
            <input class="InputAddOn-field" type="password" value="" placeholder="" name="mdp" id="mdp_id" required>
        </p>
        <p>
            <input type="submit" value="Envoyer" />
        </p>
        <input type='hidden' name='controleur' value='utilisateur'>
        <input type='hidden' name='action' value='connecter'>
    </fieldset>
</form>