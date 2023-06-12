<?php
namespace Functions;
class Utils{

    public static function isJson(string $json): bool
    {
        json_decode($json);
        return json_last_error() === JSON_ERROR_NONE;
    }

    public static function getRequestBody(){
        $body = file_get_contents('php://input');
        if(self::isJson($body)){
            return json_decode($body,true);
        }
        return null;

    }


}


