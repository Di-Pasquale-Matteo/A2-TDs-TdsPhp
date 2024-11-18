<?php

namespace App\Covoiturage\Configuration;

class ConfigurationSite
{
    static private $dureeExpiration = 30;

    static public function getDureeExpiration(): int{
        return self::$dureeExpiration;
    }
}