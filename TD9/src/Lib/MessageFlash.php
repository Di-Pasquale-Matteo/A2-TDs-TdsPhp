<?php
namespace App\Covoiturage\Lib;

use App\Covoiturage\Modele\HTTP\Session;

class MessageFlash
{

    // Les messages sont enregistrés en session associée à la clé suivante
    private static string $cleFlash = "_messagesFlash";

    // $type parmi "success", "info", "warning" ou "danger"
    public static function ajouter(string $type, string $message): void
    {
        $messageFlash = self::lireTousMessages();
        $messageFlash[$type][] = $message;
        //$_SESSION[self::$cleFlash] = $messageFlash;
        Session::getInstance()->enregistrer(self::$cleFlash,$messageFlash);
    }

    public static function contientMessage(string $type): bool
    {
        return isset($_SESSION[self::$cleFlash][$type]);
    }

    // Attention : la lecture doit détruire le message
    public static function lireMessages(string $type): array
    {
        if (self::contientMessage($type)) {
            $valeur = $_SESSION[self::$cleFlash][$type];
            unset($_SESSION[self::$cleFlash][$type]);
            return $valeur;
        }
        return [];
    }

    public static function lireTousMessages() : array
    {
        if (!Session::getInstance()->contient(self::$cleFlash)) {
            return [];
        }
        $messageFlash = Session::getInstance()->lire(self::$cleFlash) ?? [];
        Session::getInstance()->supprimer(self::$cleFlash);
        return $messageFlash;
    }

}