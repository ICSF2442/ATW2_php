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

    if ($json["calculus"] != null) {
        $calculusID = $json["calculus"];
    }
    if ($calculusID == null) {
        $request->setError("Erro!");
        $request->setIsError(true);
        echo($request->response(false));
        die();
    }
    $arr = Utils::obterArrayCanditos($calculusID);
    foreach($arr as $i) $ret[] = $i->toArray();
    echo($request->setResult($ret)->response(false));

}