<?php

require_once('./../../settings.php');

use Functions\Utils;
use Objects\RequestResponse;
use Objects\Idea;

$request = new RequestResponse();

$json = Utils::getRequestBody();
if (isset($_SESSION["user"])) {
    $userID = $_SESSION["user"]->getId();
    if($userID == null) {
        $request->setError("Erro!");
        $request->setIsError(true);
        echo($request->response(false));
        die();
    }
    $arr = Utils::obterArrayCalculus($userID);
    $ret = array();
    foreach($arr as $i){
        $ret[] = $i->toArray();
    }
    echo($request->setResult($ret)->response(false));
} else {
    $request->setError("Erro! Sessao nao logada");
    $request->setIsError(true);
    echo($request->response(false));

}