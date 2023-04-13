<?php

class Login {
    public static function loginByPhone(string $phone = "", string $password = ""): string {
        $airlandPdo = Shared::getAirlandPdo();

        $select = <<<SQL
SELECT `token` 
FROM `users` 
WHERE `phone` = ? AND `password` = ?
SQL;

        $result = $airlandPdo->prepare($select);
        $result->execute([$phone, $password]);

        if (!$result->rowCount()) {
            return "wrong";
        }

        return $result->fetch()["token"];
    }

    public static function loginByEmail(string $email = "", string $password = ""): string {
        $airlandPdo = Shared::getAirlandPdo();

        $select = <<<SQL
SELECT `token` 
FROM `users` 
WHERE `email` = ? AND `password` = ?
SQL;

        $result = $airlandPdo->prepare($select);
        $result->execute([$email, $password]);

        if (!$result->rowCount()) {
            return "wrong";
        }

        return $result->fetch()["token"];
    }

    public static function login(string $ep = "", string $password = "", bool $useEmail = false): string {
        if ($useEmail) {
            return self::loginByEmail($ep, $password);
        }

        return self::loginByPhone($ep, $password);
    }
}