<?php

namespace ServicesFnc\core;


abstract class FncAbstract
{
    private $client;

    protected static $QA_API_URL = 'https://uat.appraisalport.com/api/';

    protected static $QA_TOKEN_URL = 'https://uat.appraisalport.com/token';

    protected function loginCall($username, $password, $grantType)
    {
        $params = array(
            'form_params' => array(
                'username' => $username,
                'password' => $password,
                'grant_type' => $grantType
            )
        );

        $response =$this->call('POST', self::$QA_TOKEN_URL, $params);
        $contents = $response->getBody()->getContents();
        $data = json_decode($contents);
        return $data->access_token;

    }


    /**
     * @param $method
     * @param $url
     * @param array $params
     * @return string
     */
    protected function call($method, $url, array $params)
    {
        try {
            $result = $this->client->$method($url, $params);
            return $result;
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

}