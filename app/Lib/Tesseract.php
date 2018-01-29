<?php
/**
 * Created by PhpStorm.
 * User: hamid
 * Date: 11/7/17
 * Time: 12:10 PM
 */

namespace App\Lib;


class Tesseract
{
    const URL = 'http://tesseract01-a.appson.local';
    const URI = [
                    'putTagOnAccount'       => self::URL.'/api/accounts/a/%s/tags/ns/%s/t/%s',
                    'DeleteTagFromAccount'  => self::URL.'/api/accounts/a/$s/tags/ns/%s/t/%s',
    ];

    /**
     * @param $account
     * @param $name_space
     * @param $tag
     * @return bool
     */
    public static function putTagOnAccount($account, $name_space, $tag)
    {
        $client = new CurlRequest();
        $client->sendCurlRequest(sprintf(self::URI[__FUNCTION__], $account, $name_space, $tag), 'put');
        return ($client) ? true : false;
    }

    /**
     * @param $account
     * @param $name_space
     * @param $tag
     * @return bool
     */
    public static function DeleteTagFromAccount($account, $name_space, $tag)
    {
        $client = new CurlRequest();
        $client->sendCurlRequest(sprintf(self::URI[__FUNCTION__], $account, $name_space, $tag), 'delete');
        return ($client) ? true : false;
    }

}