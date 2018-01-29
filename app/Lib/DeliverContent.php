<?php
/**
 * Created by PhpStorm.
 * User: hamid
 * Date: 8/6/17
 * Time: 3:01 PM
 */

trait DeliverContent
{
    /**
     * @return string
     */
    private function readKeyFile()
    {
        //read private key file
        $key_file    = fopen(storage_path('framework/keys/messaging/private.rsa'),"r");
        $private_key = fread($key_file, 8192);
        fclose($key_file);

        return $private_key;
    }

    /**
     * @param $message
     * @return array
     */
    protected function sendMessageViaSMS($message)
    {
        $private_key = openssl_pkey_get_private($this->readKeyFile());

        //set required body parameters
        $text = [
            'Content' => $message,
        ];

        openssl_sign($message, $signature, $private_key); //sign given data with private key
        openssl_free_key($private_key);

        $text['ContentType'] = 0;
        $text['Signature']   = base64_encode($signature);

        return $text;
    }
}