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

    if ($json["idea"] != null) {
        $ideaTexto = $json["idea"];
    }

    if ($ideaTexto != null) {

        $idea = new Idea();
        $idea->setIdea($ideaTexto);
        $idea->store();
        echo($request->setResult($idea->toArray())->response(false));
    } else {
        $request->setError("O texto da ideia nao pode ser nulo");
        $request->setIsError(true);
        echo($request->response(false));
    }
}
