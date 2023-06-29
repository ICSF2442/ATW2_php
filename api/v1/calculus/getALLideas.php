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
    $ret = null;
    $arr = null;
    $rat = null;
    $megarray = null;

    if($json["calculus"] != null){
        $calculusID = $json["calculus"];
    }
    $arr = Utils::obterArrayCanditos($calculusID);
    foreach($arr as $i){
        $ret = Utils::obterArrayIdeias($i->getId());
        foreach ($ret as $value) {
            $megarray[] = $value->getId();
        }
    }
    $uniqueArray = array_unique($megarray);

    foreach($uniqueArray as $i){
        $idea = new Idea($i);

        $rat[] = $idea->toArray();
    }
    echo($request->setResult($rat)->response(false));
}
