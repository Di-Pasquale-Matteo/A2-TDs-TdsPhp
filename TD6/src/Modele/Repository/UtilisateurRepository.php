<?php
namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use App\Covoiturage\Modele\Repository\ConnexionBaseDeDonnees;
use App\Covoiturage\Modele\DataObject\Utilisateur;

class UtilisateurRepository extends AbstractRepository{

    protected function getNomTable(): string
    {
        return "utilisateur";
    }

    protected function getNomClePrimaire(): string
    {
        return "login";
    }

    protected function getNomsColonnes(): array
    {
        return ["login", "nom", "prenom"];
    }

    protected function formatTableauSQL(AbstractDataObject $utilisateur): array
    {
        /** @var Utilisateur $utilisateur */
        return array(
            "loginTag" => $utilisateur->getLogin(),
            "nomTag" => $utilisateur->getNom(),
            "prenomTag" => $utilisateur->getPrenom(),
        );
    }

    protected function construireDepuisTableauSQL(array $objetFormatTableau): Utilisateur
    {
        $utilisateur = new Utilisateur($objetFormatTableau['login'], $objetFormatTableau['nom'], $objetFormatTableau['prenom']);
        return $utilisateur;
    }

}
