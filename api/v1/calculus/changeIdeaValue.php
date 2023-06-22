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

    if ($json["idea"] != null) {
        $ideaTexto = $json["idea"];
    }
    if ($json["value"] != null) {
        $ideaValue = $json["value"];
    }

    if ($ideaTexto != null && $ideaValue != null) {
       $ret[] = Idea::search(null,$ideaTexto,null);
       $idIdea = $ret[0]["id"];
       $idea = new Idea();
       $idea->setId($idIdea);
       $idea->setValue($ideaValue);

        $idea->store();
        echo($request->setResult($idea->toArray())->response(false));
    } else {
        $request->setError("Erro!");
        $request->setIsError(true);
        echo($request->response(false));
    }
}
