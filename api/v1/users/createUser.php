<?php
require_once('./../../settings.php');

use Cassandra\Date;
use Functions\Database;

use Functions\Utils;
use Objects\RequestResponse;
use Objects\User;

$now = 2023;

$request = new RequestResponse();

$json = Utils::getRequestBody();
if($json == null){
    echo "ERRO! JSON INVALIDO!";

}else {
    $username = null;
    $email = null;
    $password = null;
    $birthday = null;
    $user_number = null;

    if ($json["username"] != null) {
        $username = $json["username"];
    }
    if ($json["email"] != null) {
        $email = $json["email"];
    }
    if ($json["password"] != null) {
        $password = $json["password"];
    }
    if ($json["birthday"] != null) {
        $birthday = $json["birthday"];
    }



    if ($username != null && $email != null && $password != null && $birthday != null) {

        preg_match('/\d{3}[a-zA-Z0-9]/',$birthday, $teste);
         $teste_value = (int) $teste[0];

        $age = $now - $teste_value;
        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword(hash('sha256', $password));
        if($age<16){
            $request->setError("O usuário tem que ser maior que 16 anos!");
            $request->setIsError(true);
            $request->setResult($user->toArray());
            echo($request->response(false));
            die();
        }
        $user->setBirthday($birthday);
        $user->setUserNumber();

        if (User::find(NULL, $user->getUsername(), NULL, NULL) == 1) {
            $request->setError("Nome de usuário já existe!");
            $request->setIsError(true);
            $request->setResult($user->toArray());
            echo($request->response(false));
            die();
        }
        if (User::find(NULL, NULL, $user->getEmail(), NULL) == 1) {
            $request->setError("Email já usado!");
            $request->setIsError(true);
            $request->setResult($user->toArray());
            echo($request->response(false));
            die();
        }
        $user->setVerification(0);
        $user->setDev(0);
        $user->setStatus(1);
        $user->store();
        echo($request->setResult($user->toArray())->response(false));


    }else{
        $request->setError("Valores inválidos");
        $request->setIsError(true);
        echo($request->response(false));
    }
}



