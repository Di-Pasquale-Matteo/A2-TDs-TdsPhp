<?php

namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use App\Covoiturage\Modele\DataObject\Utilisateur;

abstract class AbstractRepository{


    public function mettreAJour(AbstractDataObject $objet): void
    {
        $nomClePrimaire = $this->getNomClePrimaire();
        $sql = "UPDATE ". $this->getNomTable() ." SET ".join(",",array_map(fn($key) => "$key=:{$key}Tag", $this->getNomsColonnes()))." WHERE ".$nomClePrimaire." =:".$nomClePrimaire."Tag";
        //echo $sql;
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = $this->formatTableauSQL($objet);
        $pdoStatement->execute($values);
    }

    public function ajouter(AbstractDataObject $objet): void
    {
        $sql = "INSERT INTO ".$this->getNomTable()." (" . join(",",$this->getNomsColonnes()) .") VALUES (".join(",",array_map(fn($key) => ":$key", array_keys($this->formatTableauSQL($objet)))).")";
        echo $sql;
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = $this->formatTableauSQL($objet);
        $pdoStatement->execute($values);
    }

    public function recupererParClePrimaire(string $clePrimaire): ?AbstractDataObject
    {

        $sql = "SELECT * from ".$this->getNomTable()." WHERE ".$this->getNomClePrimaire()." = :clePrimaireTag";
        // Préparation de la requête
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = array(
            "clePrimaireTag" => $clePrimaire,
            //nomdutag => valeur, ...
        );
        // On donne les valeurs et on exécute la requête
        $pdoStatement->execute($values);

        // On récupère les résultats comme précédemment
        // Note: fetch() renvoie false si pas d'utilisateur correspondant
        $objetFormatTableau = $pdoStatement->fetch();

        if (!$objetFormatTableau) {
            return null;
        } else {
            return $this->construireDepuisTableauSQL($objetFormatTableau);
        }
    }

    protected abstract function construireDepuisTableauSQL(array $objetFormatTableau): AbstractDataObject;

    public function recuperer(): array
    {
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->query("SELECT * FROM " . $this->getNomTable());
        $tableau = [];
        foreach ($pdoStatement as $objetFormatTableau) {
            //var_dump($objetFormatTableau["id"]);
            $tableau[] = $this->construireDepuisTableauSQL($objetFormatTableau);
        }
        return $tableau;
    }

    public function supprimer(string $valeurClePrimaire): void
    {
        $sql = "DELETE FROM " . $this->getNomTable() ." WHERE " . $this->getNomClePrimaire() ." = :valeurClePrimaire";
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = array(
            "valeurClePrimaire" => $valeurClePrimaire,
        );
        $pdoStatement->execute($values);
    }



    protected abstract function getNomTable(): string;

    protected abstract function getNomClePrimaire(): string;

    protected abstract function getNomsColonnes(): array;

    protected abstract function formatTableauSQL(AbstractDataObject $objet): array;

}
