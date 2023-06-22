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
    $candidateName = null;

    if ($json["idea"] != null) {
        $ideaTexto = $json["idea"];
    }
    if($json["candidate"] != null){
        $candidateName = $json["candidate"];
    }

    if ($ideaTexto != null && $candidateName != null) {
       if(Idea::find(null,$ideaTexto,null) == 1){
           $request->setError("Ideia já existe!");
           $request->setIsError(true);
           echo($request->response(false));
           die();
       }
       $ret = \Objects\Candidate::search(null,$candidateName);
        $idea = new Idea();
        $idea->setIdea($ideaTexto);
        $idea->store();
        $candidateId = $ret[0]["id"];
        $idea->addCandidate($candidateId);
        echo($request->setResult($idea->toArray())->response(false));
    } else {
        $request->setError("A ideia nao pode ser nula");
        $request->setIsError(true);
        echo($request->response(false));
    }
}
