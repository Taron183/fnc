<?php

namespace ServicesFnc\core;
use GuzzleHttp\Client;

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
        $headers = self::headers($accessToken);
        $response = self::call('GET', self::$QA_API_URL.'orders/'.$orderId.'/files', 'null', $headers);
        $fileRequestResponse = $response->getBody()->getContents();
        return $fileRequestResponse;
    }


    /**
     * @param $accessToken
     * @param $orderId
     * @return \SimpleXMLElement
     */
    public static function callSnapshotRequest($accessToken, $orderId)
    {
        $headers = self::headers($accessToken);
        $response = self::call('GET', self::$QA_API_URL.'orders/'.$orderId.'/propertyDataSnapshot', 'null', $headers);
        $content = $response->getBody()->getContents();
        $string = json_decode($content);
        $xml = simplexml_load_string($string);
        return $xml;
    }





    public static function callOnHoldStatus($accessToken, $serviceProviderId, $orderId, $reasonCode)
    {
        $headers = self::headers($accessToken);
        $response = self::call('GET', self::$QA_API_URL.'serviceproviders/'.$serviceProviderId.'/orders/'.$orderId.'/onHold/'.$reasonCode, 'null', $headers);
        $content = $response->getBody()->getContents();
        return $content;
    }



    /**
     * @param $accessToken
     * @param $serviceProviderId
     * @param $orderId
     * @return mixed
     */
    public static function 	callOffHoldStatus($accessToken, $serviceProviderId, $orderId)
    {
        $headers = self::headers($accessToken);
        $response = self::call('GET', self::$QA_API_URL.'serviceproviders/'.$serviceProviderId.'/orders/'.$orderId.'/offHold', 'null', $headers);
        $content = $response->getBody()->getContents();
        return $content;
    }



    /**
     * @param $accessToken
     * @param $serviceProviderId
     * @param $orderId
     * @param $comment
     * @param $committedDate
     * @return mixed
     */
    public static function callOrderPastDue($accessToken, $serviceProviderId, $orderId, $comment, $committedDate)
    {
        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type'        => 'application/x-www-form-urlencoded',
        ];
        $params = [
            'Comments' => $comment,
            'CommittedDate' => $committedDate,
        ];
        $response = self::call('POST', self::$QA_API_URL.'serviceproviders/'.$serviceProviderId.'/orders/'.$orderId.'/reportPastDue', $params, $headers);
        $content = $response->getBody()->getContents();
        return $content;
    }


    /**
     * @param $accessToken
     * @param $orderId
     * @return mixed
     */
    public static function callGetEglAsHtml($accessToken, $orderId)
    {
        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type'        => 'application/x-www-form-urlencoded',
        ];
        $response = self::call('GET', self::$QA_API_URL.'orders/'.$orderId.'/egl', 'null', $headers);
        $content = $response->getBody()->getContents();
        $data = json_decode($content);
        return $data;
    }




    /**
     * @param $accessToken
     * @param $orderId
     * @return mixed
     */
    public static function callGetEglAsPdf($accessToken, $orderId)
    {
        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type'        => 'application/x-www-form-urlencoded',
        ];
        $response = self::call('GET', self::$QA_API_URL.'orders/'.$orderId.'/EngagementLetter/Pdf', 'null', $headers);
        $content = $response->getBody()->getContents();
        return $content;
	}




    /**
     * @param $method
     * @param $url
     * @param array $params
     * @return string
     */
    protected static function call($method, $url,  $params=null, $headers=null)
    {
        try {
            $client = new Client();
            if(isset($headers) && isset($headers)) {
                $result = $client->$method($url,  ['headers' => $headers, 'form_params' => $params]);
            }elseif(isset($headers)) {
                $result = $client->$method($url,  $headers);
            } elseif(isset($params)) {
                $result = $client->$method($url, $params);
            }
            return $result;
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    /**
     * @param $accessToken
     * @return array
     */
    protected static function headers($accessToken)
    {
        return [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Accept' => 'application/json',
            ]
        ];
    }

}