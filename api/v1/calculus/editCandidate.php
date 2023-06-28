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
    $candidateName = null;
    $CandidatePhoto= null;

    if ($json["candidate"] != null) {
        $candidateID = $json["candidate"];
    }
    if ($json["candidateName"] != null) {
        $candidateName = $json["candidateName"];
    }
    if ($json["candidatePhoto"] != null) {
        $CandidatePhoto = $json["candidatePhoto"];
    }

    if ($candidateName != null) {
        $idea = new \Objects\Candidate($candidateID);
        $idea->setName($candidateName);
        $idea->store();
        echo($request->setResult($idea->toArray())->response(false));
    } else {
        $request->setError("Erro!");
        $request->setIsError(true);
        echo($request->response(false));
    }

    if ($CandidatePhoto != null) {
        $idea = new \Objects\Candidate($candidateID);
        $idea->setPhoto($CandidatePhoto);
        $idea->store();
        echo($request->setResult($idea->toArray())->response(false));
    } else {
        $request->setError("Erro!");
        $request->setIsError(true);
        echo($request->response(false));
    }
}