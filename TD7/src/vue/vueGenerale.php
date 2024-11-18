<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../ressources/css/navstyle.css">
    <meta charset="UTF-8">
    <title><?php
        /** @var string $titre */
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
                <a href="controleurFrontal.php?action=afficherFormulairePreference"><img src="../ressources/images/heart.png" alt="hearth.png"></a>
            </li>
        </ul>
    </nav>
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