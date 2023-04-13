<?php

include "SMS.php";
include "Register.php";

class VerificationsManager {
    private static function register(string $email = "", string $password = "", string $phone = ""): array {
        $response = [];

        $result = Register::register($email, $password, $phone);

        if ($result == "exist") {
            $response["status"] = "failed";
            $response["message"] = "電子信箱或手機號碼已註冊";
            $response["redirect"] = "../register/";
        } else if ($result == "success") {
            $response["status"] = "success";
            $response["redirect"] = "../login/";
        } else {
            $response["status"] = "failed";
            $response["message"] = "發生了未知的錯誤";
        }

        return $response;
    }

    public static function executeCode(string $code = "", string $token = ""): string {
        $action = self::getAction($code, $token);

        $response = [];

        if ($action == "not exist") {
            $response["status"] = "failed";
            $response["message"] = "驗證碼錯誤";

            return json_encode($response);
        }

        $action = json_decode($action, true);

        if ($action["action"] == "register") {
            $response = self::register($action["email"], $action["password"], $action["phone"]);
        }

        return json_encode($response);
    }

    public static function getAction(string $code = "", string $token = ""): string {
        $airlandPdo = Shared::getAirlandPdo();

        $select = <<<SQL
SELECT `action` 
FROM `verifications` 
WHERE `code` = ? AND `token` = ?
SQL;

        $result = $airlandPdo->prepare($select);
        $result->execute([$code, $token]);

        if (!$result->rowCount()) {
            return "not exist";
        }

        return $result->fetch()["action"];
    }

    public static function sendPhoneVerification(string $phone = "", array $action = []): string {
        $sms = new SMS($phone);
        $code = self::generateCode();

        if ($sms->sendSMS("您的空島圖書系統驗證碼為: " . $code) != "success") {
            return "failed";
        }

        $token = Shared::generateRandomText(50);

        $airlandPdo = Shared::getAirlandPdo();

        $insert = <<<SQL
INSERT INTO `verifications` 
SET `code` = ?, 
    `action` = ?,
    `token` = ?
SQL;

        $result = $airlandPdo->prepare($insert);
        $result->execute([$code, json_encode($action), $token]);

        return $token;
    }

    public static function generateCode(): string {
        $chars = "0123456789";
        $code = "";

        for ($i = 0; $i < 6; $i++) {
            $code .= $chars[rand(0, strlen($chars) - 1)];
        }

        return $code;
    }
}