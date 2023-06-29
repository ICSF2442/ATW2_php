<?php
require_once('./../../settings.php');

use Functions\Database;

use Functions\Utils;
use Objects\RequestResponse;
use Objects\User;

$request = new RequestResponse();

$json = Utils::getRequestBody();


    $request = new RequestResponse();
    $request->setIsError(false);
    $request->setResult(array("status" => isset($_SESSION["user"])));
    echo($request->response(false));


