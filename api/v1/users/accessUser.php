<?php
require_once('./../../settings.php');
use Functions\Database;

use Functions\Utils;
use Objects\RequestResponse;
use Objects\User;

$request = new RequestResponse();

$json = Utils::getRequestBody();

if($json == null){
    echo "ERRO! JSON INVALIDO!";

}else {
    $email = null;
    $password = null;


    if ($json["email"] != null) {
        $email = $json["email"];
    }
    if ($json["password"] != null) {
        $password = $json["password"];
    }
    if ($email != null && $password != null) {

        $password=hash('sha256',$password);

        if(User::find(NULL,NULL,$email,$password) == 1){

            $ret = User::search(NULL,NULL,$email,$password);
            $request->setResult($ret[0]->toArray());
            $_SESSION["user"] = $ret[0];
            echo($request->response(false));

        }else{

            $request->setError("Email ou password invalidos!");
            $request->setIsError(true);
            echo($request->response(false));
        };
    }
}
