<?php

namespace ServicesFnc;

use ServicesFnc\core\FncAbstract;


class Fnc extends FncAbstract
{

    /**
     * @param $username
     * @param $password
     * @param string $grantType
     * @return access_token
     */
    public static function login($username, $password, $grantType = 'password')
    {
        return self::loginCall($username, $password, $grantType);
    }


    /**
     * @param $accessToken
     * @param $orderId
     * @return mixed
     */
    public static function  fileRequest($accessToken, $orderId)
    {
        return self::callFileRequest($accessToken, $orderId);
    }


    /**
     * @param $accessToken
     * @param $orderId
     * @return \SimpleXMLElement
     */
    public static function snapshotRequest($accessToken, $orderId)
    {
        return self::callSnapshotRequest($accessToken, $orderId);
    }




    /**
     * @param $accessToken
     * @param $transactionId
     * @return mixed
     */
    public static function onHoldStatus($accessToken, $serviceProviderId, $orderId, $reasonCode)
    {
       return self::callOnHoldStatus($accessToken, $serviceProviderId, $orderId, $reasonCode);
    }


    /**
     * @param $accessToken
     * @param $serviceProviderId
     * @param $orderId
     * @return mixed
     */
    public static function 	offHoldStatus($accessToken, $serviceProviderId, $orderId)
    {
        return self::callOffHoldStatus($accessToken, $serviceProviderId, $orderId);
    }


    /**
     * @param $accessToken
     * @param $serviceProviderId
     * @param $orderId
     * @param $comment
     * @param $committedDate
     * @return mixed
     */
    public static function orderPastDue($accessToken, $serviceProviderId, $orderId, $comment, $committedDate)
    {
        return self::callOrderPastDue($accessToken, $serviceProviderId, $orderId, $comment, $committedDate);
    }


    /**
     * @param $accessToken
     * @param $orderId
     * @return mixed
     */
    public static function getEglAsHtml($accessToken, $orderId)
    {
        return self::callGetEglAsHtml($accessToken, $orderId);
    }





    /**
     * @param $accessToken
     * @param $orderId
     * @return mixed
     */
    public static function getEglAsPdf($accessToken, $orderId)
    {
        return self::callGetEglAsPdf($accessToken, $orderId);
	}



}