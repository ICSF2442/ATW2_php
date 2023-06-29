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
    $ideaTexto = null;
    $ideaValue = null;
    $ideaID = null;


    if ($json["idea"] != null) {
        $ideaID = $json["idea"];
    }
    if (isset($json["ideaText"])) {
        $ideaTexto = $json["ideaText"];
    }
    if ($json["value"] != null) {
        $ideaValue = $json["value"];
    }

    if ($ideaTexto != null) {
        $idea = new Idea($ideaID);
        $idea->setIdea($ideaTexto);
        $idea->store();
        echo($request->setResult($idea->toArray())->response(false));
    }

    if ($ideaValue != null) {
       $idea = new Idea($ideaID);
       $idea->setValue($ideaValue);
       $idea->store();
        echo($request->setResult($idea->toArray())->response(false));
    }

    if($ideaTexto == null and $ideaValue == null){
        $request->setError("Erro!");
        $request->setIsError(true);
        echo($request->response(false));
    }
}
