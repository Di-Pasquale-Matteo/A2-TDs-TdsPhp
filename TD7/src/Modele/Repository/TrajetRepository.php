<?php

namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\Trajet;
use App\Covoiturage\Modele\Repository\UtilisateurRepository;
use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use DateTime;

class TrajetRepository extends AbstractRepository{

    protected function getNomTable(): string
    {
        return "trajet";
    }

    protected function getNomClePrimaire(): string
    {
        return "id";
    }

    protected function getNomsColonnes(): array
    {
        return ["id", "depart", "arrivee","date","prix","conducteurLogin","nonFumeur"];
    }

    protected function formatTableauSQL(AbstractDataObject $trajet): array
    {
        /** @var Trajet $trajet */
        return array(
            "idTag" => $trajet->getId(),
            "departTag" => $trajet->getDepart(),
            "arriveeTag" => $trajet->getArrivee(),
            "dateTag" => $trajet->getDate()->format('Y-m-d'),
            "prixTag" => $trajet->getPrix(),
            "conducteurLoginTag"=>$trajet->getConducteur()->getLogin(),
            "nonFumeurTag"=>$trajet->isNonFumeur()?1:0,
        );
    }

    protected function construireDepuisTableauSQL(array $objetFormatTableau) : Trajet {
        $trajet = new Trajet(
            $objetFormatTableau['id'],
            $objetFormatTableau['depart'],
            $objetFormatTableau['arrivee'],
            new DateTime($objetFormatTableau['date']),
            $objetFormatTableau['prix'],
            (new UtilisateurRepository())->recupererParClePrimaire($objetFormatTableau['conducteurLogin']) ,
            $objetFormatTableau['nonFumeur'],
        );
        $trajet->setPassagers(TrajetRepository::recupererPassagers($trajet));
        return $trajet;
    }

    static public function recupererPassagers(Trajet $trajet): array {
        $pdoStatement = ConnexionBaseDeDonnees::getPDO()->prepare("SELECT * FROM utilisateur u
        JOIN passager p ON p.passagerLogin = u.login
        WHERE p.trajetId = :trajetId");
        $values = array("trajetId" => $trajet->getId());
        $pdoStatement->execute($values);

        $passagers = [];
        foreach($pdoStatement as $passagerFormatTableau) {
            $passagers[] = (new UtilisateurRepository())->construireDepuisTableauSQL($passagerFormatTableau);
        }
        return $passagers;
    }

    /*public static function recupererTrajets() : array {
        $pdoStatement = ConnexionBaseDeDonnees::getPDO()->query("SELECT * FROM trajet");

        $trajets = [];
        foreach($pdoStatement as $trajetFormatTableau) {
            $trajets[] = TrajetRepository::construireDepuisTableauSQL($trajetFormatTableau);
        }

        return $trajets;
    }*/
}
