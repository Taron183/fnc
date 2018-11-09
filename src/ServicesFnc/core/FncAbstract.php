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
        $client = new Client();
        $response = $client->post(
            self::$QA_TOKEN_URL,
            array(
                'form_params' => array(
                    'username' => $username,
                    'password' => $password,
                    'grant_type' => $grantType
                )
            )
        );

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

        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Accept'        => 'application/json',
        ];
        $client = new Client();
        $response = $client->request('GET', self::$QA_API_URL.'orders/'.$orderId.'/files', [
            'headers' => $headers
        ]);

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
        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Accept'        => 'application/json',
        ];
        $client = new Client();
        $response = $client->request('GET', self::$QA_API_URL.'orders/'.$orderId.'/propertyDataSnapshot', [
            'headers' => $headers
        ]);

        $content = $response->getBody()->getContents();
        $string = json_decode($content);
        $xml = simplexml_load_string($string);
        return $xml;
    }





    public static function callOnHoldStatus($accessToken, $serviceProviderId, $orderId, $reasonCode)
    {
        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Accept'        => 'application/json',
        ];
        $client = new Client();
        $response = $client->request('GET', self::$QA_API_URL.'serviceproviders/'.$serviceProviderId.'/orders/'.$orderId.'/onHold/'.$reasonCode, [
            'headers' => $headers
        ]);

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
        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Accept'        => 'application/json',
        ];
        $client = new Client();
        $response = $client->request('GET', self::$QA_API_URL.'serviceproviders/'.$serviceProviderId.'/orders/'.$orderId.'/offHold', [
            'headers' => $headers
        ]);

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

        $formParams = [
            'Comments' => $comment,
            'CommittedDate' => $committedDate,
        ];
        $client = new Client();
        $response = $client->request('POST', self::$QA_API_URL.'serviceproviders/'.$serviceProviderId.'/orders/'.$orderId.'/reportPastDue', [
            'headers' => $headers,
            'form_params' => $formParams
        ]);
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
        $client = new Client();
        $response = $client->request('GET', self::$QA_API_URL.'orders/'.$orderId.'/egl', [
            'headers' => $headers
        ]);

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

        $client = new Client();
        $response = $client->request('GET', self::$QA_API_URL.'orders/'.$orderId.'/EngagementLetter/Pdf', [
            'headers' => $headers
        ]);
        $content = $response->getBody()->getContents();
        return $content;
    }



}
