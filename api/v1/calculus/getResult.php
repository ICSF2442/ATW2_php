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

        $result = null;
        $calculus = new \Objects\Calculus($calculusID);
        $candidate =  new \Objects\Candidate($calculus->getResult());
        $result = $candidate->getName()

        (new RequestResponse())->setResult($result)->response();

    }else{
        $request->setError("ERRO!");
        $request->setIsError(true);
        echo($request->response(false));
    }
}

