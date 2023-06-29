<?php

require_once('./../../settings.php');

use Functions\Utils;
use Objects\RequestResponse;
use Objects\Idea;

$request = new RequestResponse();

$json = Utils::getRequestBody();
if ($json == null) {
    echo "ERRO! JSON INVALIDO!";

} else {
    $userID = null;
    $ret = null;

    if ($json["user"] != null) {
        $userID = $json["user"];
    }
    if($userID == null) {
        $request->setError("Erro!");
        $request->setIsError(true);
        echo($request->response(false));
        die();
    }
    echo($request->setResult(Utils::obterArrayCalculus($userID))->response(false));

}