<?php

namespace App\Covoiturage\Configuration;

class ConfigurationSite
{
    static private $dureeExpiration = 30;

    static public function getDureeExpiration(): int{
        return self::$dureeExpiration;
    }

    static public function getURLAbsolue(): string {
        return 'http://localhost/tds-php/TD8/web/controleurFrontal.php';
    }

    static public function getDebug(): bool {
        return true;
    }
}