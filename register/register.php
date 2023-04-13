<?php

include "../Core/Shared.php";
include "../Core/VerificationManager.php";

function main(): void {
    if (!Shared::isPostComplete(["email", "password", "phone"])) {
        die("Invalid way.");
    }

    if (UsersManager::isUserExistByEmailPhone($_POST["email"], $_POST["phone"])) {
        die("exist");
    }

    echo VerificationManager::sendPhoneVerification($_POST["phone"], [
        "action" => "register",
        "email" => $_POST["email"],
        "password" => $_POST["password"],
        "phone" => $_POST["phone"]
    ]);
}

main();
