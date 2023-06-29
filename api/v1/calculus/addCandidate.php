<?php

require_once('./../../settings.php');

use Functions\Utils;
use Objects\RequestResponse;
use Objects\Candidate;

$now = 2023;

$request = new RequestResponse();

$json = Utils::getRequestBody();
if ($json == null) {
    echo "ERRO! JSON INVALIDO!";

} else {
    $name = null;
    $photo = null;
    $calculusID = null;

    if ($json["name"] != null) {
        $name = $json["name"];
    }
    if (isset($json["photo"])) {
        $photo = $json["photo"];
    }
    if ($json["calculus"] != null){
        $calculusID = $json["calculus"];
    }



    if ($name != null) {

        $candidate = new Candidate();
        $candidate->setName($name);
        if($photo != null) $candidate->setPhoto($photo);


        if (Candidate::find(NULL, $candidate->getName()) == 1) {
            $request->setError("Nome de candidato já existe!");
            $request->setIsError(true);
            $request->setResult($candidate->toArray());
            echo($request->response(false));
            die();
        }

        $candidate->store();
        $candidate->addCalculus($calculusID);
        echo($request->setResult($candidate->toArray())->response(false));


    } else {
        $request->setError("O nome do candidato não pode ser nulo!");
        $request->setIsError(true);
        echo($request->response(false));
    }
}