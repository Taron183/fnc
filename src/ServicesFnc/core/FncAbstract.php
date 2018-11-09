<?php

namespace ServicesFnc\core;


abstract class FncAbstract
{

    protected static $QA_API_URL = 'https://uat.appraisalport.com/api/';

    protected static $QA_TOKEN_URL = 'https://uat.appraisalport.com/token';


    /**
     * @param $username
     * @param $password
     * @param $grantType
     * @return mixed
     */
    protected  static  function loginCall($username, $password, $grantType)
    {
        $params = array(
            'form_params' => array(
                'username' => $username,
                'password' => $password,
                'grant_type' => $grantType
            )
        );

        $response = self::call('POST', self::$QA_TOKEN_URL, $params);
        $contents = $response->getBody()->getContents();
        $data = json_decode($contents);
        return $data->access_token;

    }


    /**
     * @param $accessToken
     * @param $orderId
     * @return mixed
     */
    protected static function callFileRequest($accessToken, $orderId)
    {
        $headers = self::header($accessToken);
        $response = self::call('GET', self::$QA_API_URL.'orders/'.$orderId.'/files', 'null', $headers);
        $fileRequestResponse = $response->getBody()->getContents();
        return $fileRequestResponse;
    }




    /**
     * @param $method
     * @param $url
     * @param array $params
     * @return string
     */
    protected static function call($method, $url, array $params=null, $header = null)
    {
        try {
            $client = new Client();
            $result = $client->$method($url, $params, $header);
            return $result;
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    /**
     * @param $accessToken
     * @return array
     */
    protected static function header($accessToken)
    {
        return [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Accept' => 'application/json',
            ]
        ];


    }

}