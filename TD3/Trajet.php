<?php

require_once 'ConnexionBaseDeDonnees.php';
require_once 'Utilisateur.php';

class Trajet {

    private ?int $id;
    private string $depart;
    private string $arrivee;
    private DateTime $date;
    private int $prix;
    private Utilisateur $conducteur;
    private bool $nonFumeur;
    private array $passagers;

    public function __construct(
        ?int $id,
        string $depart,
        string $arrivee,
        DateTime $date,
        int $prix,
        Utilisateur $conducteur,
        bool $nonFumeur,
    )
    {
        $this->id = $id;
        $this->depart = $depart;
        $this->arrivee = $arrivee;
        $this->date = $date;
        $this->prix = $prix;
        $this->conducteur = $conducteur;
        $this->nonFumeur = $nonFumeur;
        $this->passagers = [];
    }

    public static function construireDepuisTableauSQL(array $trajetTableau) : Trajet {
        $trajet = new Trajet(
            $trajetTableau["id"],
            $trajetTableau["depart"],
            $trajetTableau["arrivee"],
            new dateTime($trajetTableau["date"]), // À changer
            $trajetTableau["prix"],
            Utilisateur::recupererUtilisateurParLogin($trajetTableau["conducteurLogin"]) , // À changer
            $trajetTableau["nonFumeur"], // À changer ?
        );
        $trajet->passagers = $trajet->recupererPassagers();
        return $trajet;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDepart(): string
    {
        return $this->depart;
    }

    public function setDepart(string $depart): void
    {
        $this->depart = $depart;
    }

    public function getArrivee(): string
    {
        return $this->arrivee;
    }

    public function setArrivee(string $arrivee): void
    {
        $this->arrivee = $arrivee;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }

    public function getPrix(): int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): void
    {
        $this->prix = $prix;
    }

    public function getConducteur(): Utilisateur
    {
        return $this->conducteur;
    }

    public function setConducteur(Utilisateur $conducteur): void
    {
        $this->conducteur = $conducteur;
    }

    public function isNonFumeur(): bool
    {
        return $this->nonFumeur;
    }

    public function setNonFumeur(bool $nonFumeur): void
    {
        $this->nonFumeur = $nonFumeur;
    }

    public function getPassagers(): array
    {
        return $this->passagers;
    }

    public function setPassagers(array $passagers): void
    {
        $this->passagers = $passagers;
    }



    public function __toString()
    {
        $nonFumeur = $this->nonFumeur ? " non fumeur" : " ";
        return "<p>
            Le trajet$nonFumeur du {$this->date->format("d/m/Y")} partira de {$this->depart} pour aller à {$this->arrivee} (conducteur: {$this->conducteur->getPrenom()} {$this->conducteur->getNom()}).
        </p>";
    }

    /**
     * @return Trajet[]
     */
    public static function recupererTrajets() : array {
        $pdoStatement = ConnexionBaseDeDonnees::getPDO()->query("SELECT * FROM trajet");

        $trajets = [];
        foreach($pdoStatement as $trajetFormatTableau) {
            $trajets[] = Trajet::construireDepuisTableauSQL($trajetFormatTableau);
        }

        return $trajets;
    }

    public function ajouter() : void {
        $sql = "INSERT INTO trajet (depart,arrivee,date,prix,conducteurLogin,nonFumeur) VALUES (:depart,:arrivee,:date,:prix,:conducteurLogin,:nonFumeur)";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = array(
            "depart" => $this->depart,
            "arrivee" => $this->arrivee,
            "date" => $this->date->format("Y-m-d"),
            "prix" => $this->prix,
            "conducteurLogin" => $this->conducteur->getLogin(),
            "nonFumeur" => $this->nonFumeur ? 1 : 0
        );
        $pdoStatement->execute($values);
    }

    /**
     * @return Utilisateur[]
     */
    private function recupererPassagers() : array {
        $pdoStatement = ConnexionBaseDeDonnees::getPDO()->prepare("SELECT * FROM utilisateur u
        JOIN passager p ON p.passagerLogin = u.login
        WHERE p.trajetId = :trajetId");
        $values = array("trajetId" => $this->id);
        $pdoStatement->execute($values);

        $passagers = [];
        foreach($pdoStatement as $passagerFormatTableau) {
            $passagers[] = Utilisateur::construireDepuisTableauSQL($passagerFormatTableau);
        }
        return $passagers;
    }
}
