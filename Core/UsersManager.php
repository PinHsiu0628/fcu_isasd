<?php

class UsersManager {
    public static function isUserExistByEmailPhone(string $email = "", string $phone = ""): bool {
        $airlandPdo = Shared::getAirlandPdo();

        $select = <<<SQL
SELECT `id` 
FROM `users` 
WHERE `email` = ? OR `phone` = ?
SQL;

        $result = $airlandPdo->prepare($select);
        $result->execute([$email, $phone]);

        return $result->rowCount();
    }
}