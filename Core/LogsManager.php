<?php

include "Shared.php";

class LogsManager {
    private static ?PDO $airlandPdo = null;

    public function __construct() {
        if (!self::$airlandPdo) {
            self::$airlandPdo = Shared::getAirlandPdo();
        }
    }
}
