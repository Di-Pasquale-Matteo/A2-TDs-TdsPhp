<?php
namespace App\Covoiturage\Modele\HTTP;

class Cookie {

    public static function enregistrer(string $cle, mixed $valeur, ?int $dureeExpiration = null) : void {
        if (is_null($dureeExpiration) or $dureeExpiration = 0) {
            $dureeExpiration = 0;
        }
        else {
            $dureeExpiration = time() + $dureeExpiration;
        }
        setcookie($cle, (string)$valeur, $dureeExpiration);
    }

    public static function lire(string $cle) : mixed {
        if (isset($_COOKIE[$cle])) {
            return $_COOKIE[$cle];
        }
        return null;
    }

    public static function contient(string $cle) : bool {
        return isset($_COOKIE[$cle]);
    }

    public static function supprimer(string $cle) : void {
        if (isset($_COOKIE[$cle])) {
            unset($_COOKIE[$cle]);
            setcookie($cle, "", 1);
        }
    }
}
