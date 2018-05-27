<?php
/**
 * Created by PhpStorm.
 * User: Hamid
 * Date: 5/27/2018
 * Time: 11:29 PM
 */

namespace App\Lib;

/**
 * @author Pejman Kheyri

 * @author Pejman Kheyri <pejmankheyri@gmail.com>
 * @copyright © 2018 The Ide Pardazan (ipe.ir) PHP Group. All rights reserved.
 * @link http://sms.ir/ Documentation of sms.ir RESTful API PHP sample.
 * @version 1.2
 */

class Sms_GetToken {

	/**
	* gets Api Token Url.
	*
    * @return string Indicates the Url

	*/
	protected function getApiTokenUrl(){
		return "http://RestfulSms.com/api/Token";
	}

	/**
	* gets config parameters for sending request.
	*
	* @param string $APIKey API Key
	* @param string $SecretKey Secret Key
    * @return void
	*/
    public function __construct($APIKey,$SecretKey){
		$this->APIKey = $APIKey;
		$this->SecretKey = $SecretKey;
    }

	/**
	* gets token key for all web service requests.
	*
    * @return string Indicates the token key
	*/
	public function GetToken(){
		$postData = array(
			'UserApiKey' => $this->APIKey,
			'SecretKey' => $this->SecretKey,
			'System' => 'php_rest_v_1_2'
		);
		$postString = json_encode($postData);

		$ch = curl_init($this->getApiTokenUrl());
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                            'Content-Type: application/json'
                                            ));
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_POST, count($postString));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);

		$result = curl_exec($ch);
		curl_close($ch);

		$response = json_decode($result);

		if(is_object($response)){
			$resultVars = get_object_vars($response);
			if(is_array($resultVars)){
				@$IsSuccessful = $resultVars['IsSuccessful'];
				if($IsSuccessful == true){
					@$TokenKey = $resultVars['TokenKey'];
					$resp = $TokenKey;
				} else {
					$resp = false;
				}
			}
		}

		return $resp;
	}
}