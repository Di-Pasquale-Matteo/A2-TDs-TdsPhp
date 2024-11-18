<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../ressources/css/navstyle.css">
    <meta charset="UTF-8">
    <title><?php
        /** @var string $titre */

        use App\Covoiturage\Lib\ConnexionUtilisateur;

        echo $titre; ?></title>
    <nav>
        <ul>
            <li>
                <a href="controleurFrontal.php?action=afficherListe&controleur=utilisateur">Gestion des utilisateurs</a>
            </li>
            <li>
                <a href="controleurFrontal.php?action=afficherListe&controleur=trajet">Gestion des trajets</a>
            </li>
            <li>
                <a href="controleurFrontal.php?action=afficherFormulairePreference"><img
                            src="../ressources/images/heart.png" alt="hearth.png"></a>
            </li>
            <?php
            if (!ConnexionUtilisateur::estConnecte()) {
                echo '
            <li>
                <a href="controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireCreation"><img src="../ressources/images/add-user.png" alt="add-user.png"></a>
            </li>
            <li>
                <a href="controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireConnexion"><img src="../ressources/images/enter.png" alt="enter.png"></a>
            </li>';
            }
            else{
                $login =rawurlencode(ConnexionUtilisateur::getLoginUtilisateurConnecte());
                echo "
            <li>
                <a href='controleurFrontal.php?controleur=utilisateur&action=afficherDetail&login=$login'><img src='../ressources/images/user.png' alt='user.png'></a>
            </li>
            <li>
                <a href='controleurFrontal.php?controleur=utilisateur&action=deconnecter'><img src='../ressources/images/logout.png' alt='logout.png'></a>
            </li>";
            }
            ?>
        </ul>
    </nav>
    <div>
        <?php
        /** @var string[][] $messagesFlash */
        foreach($messagesFlash as $type => $messagesFlashPourUnType) {
            // $type est l'une des valeurs suivantes : "success", "info", "warning", "danger"
            // $messagesFlashPourUnType est la liste des messages flash d'un type
            foreach ($messagesFlashPourUnType as $messageFlash) {
                echo <<< HTML
            <div class="alert alert-$type">
               $messageFlash
            </div>
            HTML;
            }
        }
        ?>
    </div>
</head>
<body>
<header>
    <nav>
        <!-- Votre menu de navigation ici -->
    </nav>
</header>
<main>
    <?php
    /** @var string $cheminCorpsVue */
    require __DIR__ . "/{$cheminCorpsVue}";
    ?>
</main>
<footer>
    <p>
        Site de covoiturage de Raimon
    </p>
</footer>
</body>
</html>