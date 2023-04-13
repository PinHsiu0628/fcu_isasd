<?php

include "../Core/Shared.php";
include "../Core/VerificationManager.php";

function main(): void {
    if (!Shared::isPostComplete(["code", "token"])) {
        die("Invalid way.");
    }

    echo VerificationManager::executeCode($_POST["code"], $_POST["token"]);
}

main();
