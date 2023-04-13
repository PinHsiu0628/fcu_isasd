<?php

include "UsersManager.php";

class Register {
    public static function isTokenExist(PDOStatement $result = null, string $token = ""): bool {
        $result->execute([$token]);

        return $result->rowCount();
    }

    public static function register(string $email = "", string $password = "", string $phone = ""): string {
        if (UsersManager::isUserExistByEmailPhone($email, $phone)) {
            return "exist";
        }

        $airlandPdo = Shared::getAirlandPdo();

        $selectToken = <<<SQL
SELECT `id` 
FROM `users` 
WHERE `token` = ?
SQL;

        $resultToken = $airlandPdo->prepare($selectToken);

        $token = Shared::generateRandomText(50);

        while (self::isTokenExist($resultToken, $token)) {
            $token = Shared::generateRandomText(50);
        }

        $insertUser = <<<SQL
INSERT INTO `users` 
SET `email` = ?, `password` = ?, `phone` = ?, `token` = ?
SQL;

        $resultUser = $airlandPdo->prepare($insertUser);
        $resultUser->execute([$email, $password, $phone, $token]);

        return "success";
    }
}
