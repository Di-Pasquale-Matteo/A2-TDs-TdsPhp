<form method="get" action="controleurFrontal.php">
    <fieldset>
        <p>
            <input type="radio" id="utilisateurId" name="controleur_defaut" value="utilisateur"
                <?php

                use App\Covoiturage\Lib\PreferenceControleur;

                if (PreferenceControleur::existe()&&PreferenceControleur::lire() == "utilisateur") {
                    echo "checked";
                }
                ?>>
            <label for="utilisateurId">Utilisateur</label>
        </p>
        <p>
            <input type="radio" id="trajetId" name="controleur_defaut" value="trajet"
                <?php
                if (PreferenceControleur::existe()&&PreferenceControleur::lire() == "trajet") {
                    echo "checked";
                }
                ?>>
            <label for="trajetId">Trajet</label>
        </p>
        <p>
            <input type="submit" value="Envoyer"/>
        </p>
        <input type="hidden" name="action" value="enregistrerPreference">
    </fieldset>
</form>
