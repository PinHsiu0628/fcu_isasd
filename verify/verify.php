<?php

include "../Core/Shared.php";
include "../Core/VerificationsManager.php";

function main(): void {
    if (!Shared::isPostComplete(["code", "token"])) {
        die("Invalid way.");
    }

    echo VerificationsManager::executeCode($_POST["code"], $_POST["token"]);
}

main();
