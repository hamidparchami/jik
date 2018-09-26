<?php
/**
 * Created by PhpStorm.
 * User: hamid
 * Date: 12/31/16
 * Time: 6:21 PM
 */

namespace App\Lib;


use Illuminate\Support\Facades\Log;

class CurlRequest
{
    public $curl_headers    = array();
    public $log_parameters  = '';
    public $http_code       = NULL;
    public $response        = NULL;

    public function setCurlHeaders($header) {
        $this->curl_headers[] = $header;
    }

    public function getCurlHeaders()
    {
        return $this->curl_headers;
    }

    public function setLogParameters($info, $parameter)
    {
        $this->log_parameters .= sprintf("'%s' => %s, ", $parameter, $info[$parameter]);
    }
    public function setCurlLog(array $info)
    {
        $this->setLogParameters($info, 'url');
        $this->setLogParameters($info, 'http_code');
        $this->setLogParameters($info, 'total_time');
        $this->setLogParameters($info, 'primary_ip');
        $this->setLogParameters($info, 'local_ip');
        //set curl request log
        Log::useDailyFiles(storage_path().'/logs/curl.log');
        Log::info($this->log_parameters);
    }

    public function sendCurlRequest($url, $method = 'POST', $params = null)
    {
        $curl_request = curl_init($url);
        curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_request, CURLOPT_HEADER, 0);
        curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_request, CURLOPT_HTTPHEADER, $this->getCurlHeaders()); //CURL Headers (array)
        curl_setopt($curl_request, CURLOPT_CUSTOMREQUEST, $method); //set HTTP method

        //set curl post fields
        if($method == 'POST' && !is_null($params)) {
            curl_setopt($curl_request, CURLOPT_POSTFIELDS, $params);
        }

        $this->response     = curl_exec($curl_request);
        $this->http_code    = curl_getinfo($curl_request, CURLINFO_HTTP_CODE);

        //set curl request log
        $info = curl_getinfo($curl_request);
        $this->setCurlLog($info);

        curl_close($curl_request);

        $responseCode = substr($this->http_code, 0, 1);

        return ($responseCode == 2) ? $this->response : false;
    }
}