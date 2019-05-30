<?php
namespace app\config\components;
use Yii;
use Exception;
use nusoap_client;
class DARGAH_MELLAT {
    private static $ws_url         = 'https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl';
    private static $pay_url        = 'https://bpm.shaparak.ir/pgwchannel/startpay.mellat';
    private static $interfaces_url = 'http://interfaces.core.sw.bps.com/';
    public static function send($terminal, $username, $password, $orderId, $amount, $callBackUrl) {
        try {
            $client                   = new nusoap_client(self::$ws_url);
            $client->soap_defencoding = 'UTF-8';
            $client->decode_utf8      = false;
            $result                   = $client->call('bpPayRequest', [
                'terminalId'     => $terminal,
                'userName'       => $username,
                'userPassword'   => $password,
                'orderId'        => $orderId,
                'amount'         => $amount,
                'callBackUrl'    => Yii::$app->urlManager->createAbsoluteUrl($callBackUrl),
                'localDate'      => date('ymj'),
                'localTime'      => date('His'),
                'additionalData' => '',
                'payerId'        => 0
            ], self::$interfaces_url);
            if (!is_string($result)) {
                return [false, null, null];
            }
            $res = explode(',', $result);
            if ($res[0] != 0) {
                return [false, null, null];
            }
            return [true, ['RefId' => $res[1]], self::$pay_url];
        }
        catch (Exception $exc) {
            return [false, null, null];
        }
    }
    public static function verify($terminal, $username, $password, $ResCode, $SaleOrderId, $SaleReferenceId) {
        try {
            $rescod = $ResCode == 0;
            if (!$rescod) {
                return [false];
            }
            $client = new nusoap_client(self::$ws_url);
            $verify = self::verifyPayment($terminal, $username, $password, $client, $SaleOrderId, $SaleReferenceId);
            if (!$verify) {
                return [false];
            }
            $settle = self::settlePayment($terminal, $username, $password, $client, $SaleOrderId, $SaleReferenceId);
            if (!$settle) {
                return [false];
            }
            return [true, [
                    'resCode'         => $ResCode,
                    'saleOrderId'     => $SaleOrderId,
                    'saleReferenceId' => $SaleReferenceId,
            ]];
        }
        catch (Exception $exc) {
            return [false];
        }
    }
    private static function verifyPayment($terminal, $username, $password, $client, $SaleOrderId, $SaleReferenceId) {
        $result = $client->call('bpVerifyRequest', [
            'terminalId'      => $terminal,
            'userName'        => $username,
            'userPassword'    => $password,
            'orderId'         => $SaleOrderId,
            'saleOrderId'     => $SaleOrderId,
            'saleReferenceId' => $SaleReferenceId
                ], self::$interfaces_url);
        return ($result == '0');
    }
    private static function settlePayment($terminal, $username, $password, $client, $SaleOrderId, $SaleReferenceId) {
        $result = $client->call('bpSettleRequest', [
            'terminalId'      => $terminal,
            'userName'        => $username,
            'userPassword'    => $password,
            'orderId'         => $SaleOrderId,
            'saleOrderId'     => $SaleOrderId,
            'saleReferenceId' => $SaleReferenceId
                ], self::$interfaces_url);
        return ($result == '0');
    }
    private static function getError($number) {
        $err = 'Error code : ' . $number;
        switch ($number) {
            case 17 : $err = "کاربر از انجام تراکنش منصرف شده است!";
                break;
            case 21 : $err = "پذیرنده نامعتبر است!";
                break;
            case 25 : $err = "مبلغ نامعتبر است!";
                break;
            case 31 : $err = "پاسخ نامعتبر است!";
                break;
            case 32 : $err = "فرمت اطلاعات وارد شده صحیح نمیباشد";
                break;
            case 34 : $err = "خطای سیستمی!";
                break;
            case 35 : $err = "تاریخ نامعتبر است";
                break;
            case 41 : $err = "شماره درخواست تکراری است!";
                break;
            case 43 : $err = "درخواست verify قبلا صادر شده است";
                break;
            case 45 : $err = "تراکنش از قبل ستل شده است";
                break;
            case 46 : $err = "تراکنش ستل شده است";
                break;
            case 412 : $err = "شناسه قبض نادرست است!";
                break;
            case 421 : $err = "ای پی نامعتبر است!";
                break;
        }
        return $err;
    }
}