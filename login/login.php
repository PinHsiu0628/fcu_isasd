<?php

include "../Core/Shared.php";
include "../Core/Login.php";

function isTrue(string $string = ""): bool {
    if ($string == "true") {
        return true;
    }

    return false;
}

function main(): void {
    if (!Shared::isPostComplete(["ep", "password", "useEmail"])) {
        die("Invalid way.");
    }

    echo Login::login($_POST["ep"], $_POST["password"], isTrue($_POST["useEmail"]));
}

main();
