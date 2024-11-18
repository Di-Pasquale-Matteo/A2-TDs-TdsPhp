<?php

namespace App\Covoiturage\Modele;
use App\Covoiturage\Modele\ConnexionBaseDeDonnees;

class ModeleUtilisateur {

    private string $login;
    private string $nom;
    private string $prenom;

    // un getter
    public function getNom():string {
        return $this->nom;
    }

    // un setter
    public function setNom(string $nom) {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom():string{
        return $this->prenom;
    }

    /**
     * @return mixed
     */
    public function getLogin():string{
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin(string $login): void
    {
        $this->login = substr($login,0,64);
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }



    // un constructeur
    public function __construct(
        string $login,
        string $nom,
        string $prenom,
    ) {
        $this->login = substr($login,0,64);
        $this->nom = $nom;
        $this->prenom = $prenom;
    }

    // Pour pouvoir convertir un objet en chaîne de caractères
    /*public function __toString():string {
        return "Utilisateur $this->prenom $this->nom de login $this->login<br>";
    }*/

    public static function construireDepuisTableauSQL(array $utilisateurFormatTableau) : Utilisateur {
        $utilisateur = new Utilisateur($utilisateurFormatTableau['login'], $utilisateurFormatTableau['nom'], $utilisateurFormatTableau['prenom']);
        return $utilisateur;
    }

    public static function recupererUtilisateurs() : array{
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->query("SELECT * FROM utilisateur");
        $tableau = [];
        foreach($pdoStatement as $utilisateurFormatTableau){
            $tableau[] = self::construireDepuisTableauSQL($utilisateurFormatTableau);
        }
        return $tableau;
    }

    public static function recupererUtilisateurParLogin(string $login) : ?Utilisateur {
        $sql = "SELECT * from utilisateur WHERE login = :loginTag";
        // Préparation de la requête
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = array(
            "loginTag" => $login,
            //nomdutag => valeur, ...
        );
        // On donne les valeurs et on exécute la requête
        $pdoStatement->execute($values);

        // On récupère les résultats comme précédemment
        // Note: fetch() renvoie false si pas d'utilisateur correspondant
        $utilisateurFormatTableau = $pdoStatement->fetch();

        if (!$utilisateurFormatTableau) {
            return null;
        }
        else{
            return Utilisateur::construireDepuisTableauSQL($utilisateurFormatTableau);
        }
    }

    public function ajouter() : void {
        $sql = "INSERT INTO utilisateur (login,nom,prenom) VALUES (:login,:nom,:prenom)";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = array(
            "login" => $this->login,
            "nom" => $this->nom,
            "prenom" => $this->prenom
        );
        $pdoStatement->execute($values);
    }

}
?>