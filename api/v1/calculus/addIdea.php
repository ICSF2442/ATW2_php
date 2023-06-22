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
       if(Idea::find(null,$ideaTexto,null) == 1){
           $request->setError("Ideia já existe!");
           $request->setIsError(true);
           echo($request->response(false));
           die();
       }
        $idea = new Idea();
        $idea->setIdea($ideaTexto);
        $idea->store();
        echo($request->setResult($idea->toArray())->response(false));
    } else {
        $request->setError("A ideia nao pode ser nula");
        $request->setIsError(true);
        echo($request->response(false));
    }
}
