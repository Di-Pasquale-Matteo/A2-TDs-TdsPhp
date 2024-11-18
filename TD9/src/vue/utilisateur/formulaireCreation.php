<body>
<form method=<?php echo (\App\Covoiturage\Configuration\ConfigurationSite::getDebug()?"get":"post"); ?> action="controleurFrontal.php">
    <fieldset>
        <legend>Mon formulaire :</legend>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="login_id">Login&#42;</label>
            <input class="InputAddOn-field" type="text" placeholder="Ex : evansm" name="login" id="login_id" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="prenom_id">Prenom&#42;</label>
            <input class="InputAddOn-field" type="text" placeholder="Ex : Marc" name="prenom" id="prenom_id" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="nom_id">Nom&#42;</label>
            <input class="InputAddOn-field" type="text" placeholder="Ex : Evans" name="nom" id="nom_id" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mdp_id">Mot de passe&#42;</label>
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
            <input class="InputAddOn-field" type="checkbox" placeholder="" name="estAdmin" id="estAdmin_id">
        </p>';
        }?>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="email_id">Email&#42;</label>
            <input class="InputAddOn-field" type="email" value="" placeholder="toto@yopmail.com" name="email" id="email_id" required>
        </p>
        <p>
            <input type="submit" value="Envoyer" />
        </p>
        <input type='hidden' name='controleur' value='utilisateur'>
        <input type='hidden' name='action' value='creerDepuisFormulaire'>
    </fieldset>
</form>
</body>