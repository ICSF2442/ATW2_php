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

    if ($json["name"] != null) {
        $name = $json["name"];
    }
    if ($json["photo"] != null) {
        $photo = $json["photo"];
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
        echo($request->setResult($candidate->toArray())->response(false));


    } else {
        $request->setError("O nome do candidato não pode ser nulo!");
        $request->setIsError(true);
        echo($request->response(false));
    }
}