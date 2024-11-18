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
        return ["login", "nom", "prenom","mdpHache","estAdmin",'email','emailAValider','nonce'];
    }

    protected function formatTableauSQL(AbstractDataObject $utilisateur): array
    {
        /** @var Utilisateur $utilisateur */
        return array(
            "loginTag" => $utilisateur->getLogin(),
            "nomTag" => $utilisateur->getNom(),
            "prenomTag" => $utilisateur->getPrenom(),
            "mdpHacheTag" => $utilisateur->getMdpHache(),
            "estAdminTag" => $utilisateur->isEstAdmin()?1:0,
            "emailTag" => $utilisateur->getEmail(),
            "emailAValiderTag" => $utilisateur->getEmailAValider(),
            "nonceTag" => $utilisateur->getNonce(),
        );
    }

    protected function construireDepuisTableauSQL(array $objetFormatTableau): Utilisateur
    {
        $utilisateur = new Utilisateur($objetFormatTableau['login'], $objetFormatTableau['nom'], $objetFormatTableau['prenom'],
            $objetFormatTableau['mdpHache'], $objetFormatTableau['estAdmin'],$objetFormatTableau['email'],
            $objetFormatTableau['emailAValider'],$objetFormatTableau['nonce']);
        return $utilisateur;
    }

}
