<?php
namespace App\Covoiturage\Lib;

use App\Covoiturage\Configuration\ConfigurationSite;
use App\Covoiturage\Modele\Repository\ConnexionBaseDeDonnees;
use App\Covoiturage\Modele\DataObject\Utilisateur;
use App\Covoiturage\Modele\Repository\UtilisateurRepository;

class VerificationEmail
{
public static function envoiEmailValidation(Utilisateur $utilisateur): void
{
$destinataire = $utilisateur->getEmailAValider();
$sujet = "Validation de l'adresse email";
// Pour envoyer un email contenant du HTML
$enTete = "MIME-Version: 1.0\r\n";
$enTete .= "Content-type:text/html;charset=UTF-8\r\n";

// Corps de l'email
$loginURL = rawurlencode($utilisateur->getLogin());
$nonceURL = rawurlencode($utilisateur->getNonce());
$URLAbsolue = ConfigurationSite::getURLAbsolue();
$lienValidationEmail = "$URLAbsolue?action=validerEmail&controleur=utilisateur&login=$loginURL&nonce=$nonceURL";
$corpsEmailHTML = "<a href=\"$lienValidationEmail\">Validation</a>";

// Temporairement avant d'envoyer un vrai mail
echo "Simulation d'envoi d'un mail<br> Destinataire : $destinataire<br> Sujet : $sujet<br> Corps : <br>$corpsEmailHTML";

// Quand vous aurez configué l'envoi de mail via PHP
// mail($destinataire, $sujet, $corpsEmailHTML, $enTete);
}

public static function traiterEmailValidation($login, $nonce): bool
{
    $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($login);
    if ($utilisateur == null) {
        return false;
    }
    if ($utilisateur->getNonce() != $nonce) {
        return false;
    }
    $email = $utilisateur->getEmailAValider();
    $utilisateur->setEmailAValider("");
    $utilisateur->setNonce("");
    $utilisateur->setEmail($email);
    $sql = "UPDATE utilisateur SET email = :emailTag, emailAValider = '', nonce='' WHERE login = :loginTag";
    $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
    $values = array('loginTag' => $login, 'emailTag' => $email);
    $pdoStatement->execute($values);
    return true;
}

public static function aValideEmail(Utilisateur $utilisateur) : bool
{
    return !$utilisateur->getEmail() == "";
}
}