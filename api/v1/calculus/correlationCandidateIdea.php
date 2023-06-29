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
    $ideaID = null;
    $candidateID = null;

    if($json["idea"] != null){
        $ideaID = $json["idea"];
    }
    if($json["candidate"] != null){
        $candidateID = $json["candidate"];
    }
    if($ideaID == null or $candidateID == null){
        $request->setError("Erro!");
        $request->setIsError(true);
        echo($request->response(false));
        die();
    }
    $idea = new Idea($ideaID);
    $idea->addCandidate($candidateID);
    echo($request->setResult(null)->response(false));

}