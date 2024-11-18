<?php
class Utilisateur {

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
    public function __toString():string {
        return "Utilisateur $this->prenom $this->nom de login $this->login<br>";
    }

    public static function construireDepuisTableauSQL(array $utilisateurFormatTableau) : Utilisateur {
        $utilisateur = new Utilisateur($utilisateurFormatTableau['login'], $utilisateurFormatTableau['nom'], $utilisateurFormatTableau['prenom']);
        return $utilisateur;
    }

    public static function recupererUtiilisateurs() : array{
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->query("SELECT * FROM utilisateur");
        $tableau = [];
        foreach($pdoStatement as $utilisateurFormatTableau){
            $tableau[] = self::construireDepuisTableauSQL($utilisateurFormatTableau);
        }
        return $tableau;
    }

}
?>