<?php
namespace app\config\components;
use Yii;
use Exception;
use nusoap_client;
class DARGAH_ZARINPAL {
    private static $ws_url  = 'https://www.zarinpal.com/pg/services/WebGate/wsdl';
    private static $pay_url = 'https://www.zarinpal.com/pg/StartPay/';
    public static function send($merchant_id, $amount = 0, $Description = '', $callback = [], $Email = '', $Mobile = '') {
        try {
            $client                   = new nusoap_client(self::$ws_url, true);
            $client->soap_defencoding = 'UTF-8';
            $client->decode_utf8      = false;
            $result                   = $client->call('PaymentRequest', [
                'MerchantID'  => $merchant_id,
                'Amount'      => $amount,
                'Description' => $Description,
                'Email'       => $Email,
                'Mobile'      => $Mobile,
                'CallbackURL' => Yii::$app->urlManager->createAbsoluteUrl($callback),
            ]);
            return [$result['Status'] == 100, ['Authority' => $result['Authority']], self::$pay_url . $result['Authority']];
        }
        catch (Exception $exc) {
            return [false];
        }
    }
    public static function verify($merchant_id, $Authority, $Amount) {
        try {
            $client = new nusoap_client(self::$ws_url, true);
            $result = $client->call('PaymentVerification', [
                'MerchantID' => $merchant_id,
                'Authority'  => $Authority,
                'Amount'     => $Amount
            ]);
            return [$result['Status'] == 100, ['RefID' => $result['RefID']]];
        }
        catch (Exception $exc) {
            return [false];
        }
        return [false];
    }
}