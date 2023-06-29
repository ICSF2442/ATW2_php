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

    $calculusID = null;

    if($json["calculus"] != null){
        $calculusID = $json["calculus"];
    }
    if($calculusID != null){
        $candidatoIdeal = Utils::calcularCandidatoIdeal($calculusID);

        $calculus = new \Objects\Calculus($calculusID);

        $calculus->setResult($candidatoIdeal->getId());

        $calculus->store();

        echo($request->setResult($candidatoIdeal->toArray())->response(false));

    }else{
        $request->setError("ERRO!");
        $request->setIsError(true);
        echo($request->response(false));
    }

}