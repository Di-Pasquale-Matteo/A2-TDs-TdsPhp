<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title> Mon premier php </title>
</head>
<body>
<form method="get" action="routeur.php">
    <fieldset>
        <legend>Mon formulaire :</legend>
        <p>
            <label for="login_id">Login</label> :
            <input type="text" placeholder="evansm" name="login" id="login_id" required/>
        </p>
        <p>
            <label for="prenom_id">Prenom</label> :
            <input type="text" placeholder="Marc" name="prenom" id="prenom_id" required/>
        </p>
        <p>
            <label for="nom_id">Nom</label> :
            <input type="text" placeholder="Evans" name="nom" id="nom_id" required/>
        </p>
        <p>
            <input type="submit" value="Envoyer" />
        </p>
        <input type='hidden' name='action' value='creerDepuisFormulaire'>
    </fieldset>
</form>
</body>
</html>