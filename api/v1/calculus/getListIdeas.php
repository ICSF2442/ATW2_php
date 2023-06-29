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
    $candidateID = null;
    $ret = null;

    if ($json["calculus"] != null) {
        $candidateID = $json["calculus"];
    }
    if ($candidateID == null) {
        $request->setError("Erro!");
        $request->setIsError(true);
        echo($request->response(false));
        die();
    }
    echo($request->setResult(Utils::obterArrayIdeias($candidateID))->response(false));

}