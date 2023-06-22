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
    $name = null;
    $date = null;

    if ($json["name"] != null) {
        $name = $json["idea"];
    }
    if ($json["date"] != null) {
        $date = $json["date"];
    }

    if ($name != null && $date != null) {

        $calculus = new \Objects\Calculus();
        $calculus->setName($name);
        $calculus->setDate($date);
        $calculus->store();
        echo($request->setResult($calculus->toArray())->response(false));
    } else {
        $request->setError("Erro!");
        $request->setIsError(true);
        echo($request->response(false));
    }
}
