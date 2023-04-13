<?php

class Shared {
    private static ?PDO $airlandPdo = null;

    public static function isPostComplete(array $indexes = []): bool {
        return self::isArrayComplete($_POST, $indexes);
    }

    public static function isArrayComplete(array $array = [], array $indexes = []): bool {
        foreach ($indexes as $index) {
            if (!isset($array[$index])) {
                return false;
            }
        }

        return true;
    }

    public static function isLogin(): bool {
        return (isset($_COOKIE["airland"]) && strlen($_COOKIE["airland"]) == 50);
    }

    public static function generateRandomText(int $length = 0): string {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $token = "";

        for ($i = 0; $i < $length; $i++) {
            $token .= $chars[rand(0, strlen($chars) - 1)];
        }

        return $token;
    }

    public static function getAirlandPdo(): PDO {
        if (!self::$airlandPdo) {
            self::$airlandPdo = new PDO("mysql:host=51.79.163.230;dbname=airland", "airland", "fcu_isad");
            self::$airlandPdo->query("SET NAMES UTF8MB4");
        }

        return self::$airlandPdo;
    }
}