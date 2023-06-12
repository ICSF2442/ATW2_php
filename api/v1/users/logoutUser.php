<?php
require_once('./../../settings.php');
use Functions\Database;

use Functions\Utils;
use Objects\RequestResponse;
use Objects\User;

$_SESSION["user"] = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

(new RequestResponse())->setResult("Sessao encerrada.")->response();
// Finally, destroy the session.
session_destroy();