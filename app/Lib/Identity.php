<?php
/**
 * Created by PhpStorm.
 * User: hamid
 * Date: 12/26/16
 * Time: 12:08 PM
 */

namespace App\Lib;


use Firebase\JWT\JWT;

class Identity extends CurlRequest
{
    public function __construct($app_key=null)
    {
        ini_set("default_socket_timeout", 6); //SOAP socket timeout limit per seconds
        $this->setCurlHeaders((is_null($app_key)) ? config('general.identity_app_key') : $app_key);
    }

    public function decodeToken($token)
    {
        JWT::$leeway = 120;
        return JWT::decode($token, config('general.identity_public_key'), array('RS256'));
    }
}