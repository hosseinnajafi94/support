<?php
namespace app\config\components;
use Yii;
use Exception;
use nusoap_client;
class DARGAH_IRANKISH {
    private static $ws_url     = 'https://ikc.shaparak.ir/XToken/Tokens.xml';
    private static $pay_url    = 'https://ikc.shaparak.ir/TPayment/Payment/index';
    private static $verify_url = 'https://ikc.shaparak.ir/XVerify/Verify.xml';
    public static function send($merchant_id, $amount = 0, $Description = '', $callback = []) {
        try {
            $client                   = new nusoap_client(self::$ws_url);
            $client->soap_defencoding = 'UTF-8';
            $client->decode_utf8      = false;
            $result                   = $client->call('MakeToken', [
                'amount'      => $amount,
                'merchantId'  => $merchant_id,
                //'invoiceNo'        => null,
                //'paymentId'        => null,
                //'specialPaymentId' => null,
                'revertURL'   => Yii::$app->urlManager->createAbsoluteUrl($callback),
                'description' => $Description,
            ]);
            if (is_bool($result) && $result === false) {
                return [false, null, null];
            }
            if (!is_object($result)) {
                return [false, null, null];
            }
            if (!property_exists($result, 'MakeTokenResult')) {
                return [false, null, null];
            }
            if (!is_object($result->MakeTokenResult)) {
                return [false, null, null];
            }
            if (!property_exists($result->MakeTokenResult, 'token')) {
                return [false, null, null];
            }
            $items = ['token' => $result->MakeTokenResult->token, 'merchantId' => $merchant_id];
            return [true, $items, self::$pay_url];
        }
        catch (Exception $exc) {
            return [false, null, null];
        }
    }
    public static function verify($merchant_id, $sha1Key, $resultCode, $referenceId, $amount, $token) {
        try {
            if ($resultCode == 100) {
                $client  = new nusoap_client(self::$verify_url);
                $result  = $client->call('KicccPaymentsVerification', [
                    'token'           => $token,
                    'merchantId'      => $merchant_id,
                    'referenceNumber' => $referenceId,
                    'sha1Key'         => $sha1Key,
                ]);
                $result2 = $result->KicccPaymentsVerificationResult;
                if (floatval($result2) > 0 && floatval($result2) == floatval($amount)) {
                    return [true, [
                            'resultCode'  => $resultCode,
                            'message'     => 'پرداخت شما کامل شده است',
                            'referenceId' => $referenceId
                    ]];
                }
                return [false, [
                        'resultCode'  => $resultCode,
                        'message'     => $this->messeg2($result2),
                        'referenceId' => $referenceId
                ]];
            }
            return [false, [
                    'resultCode'  => $resultCode,
                    'message'     => $this->messeg($resultCode),
                    'referenceId' => $referenceId
            ]];
        }
        catch (Exception $exc) {
            return [false, [
                    'resultCode'  => $resultCode,
                    'message'     => $this->messeg($resultCode),
                    'referenceId' => $referenceId
            ]];
        }
    }
    private function messeg($resultCode) {
        switch ($resultCode) {
            case 110:
                return " انصراف دارنده کارت";
            case 120:
                return"   موجودی کافی نیست";
            case 130:
            case 131:
            case 160:
                return"   اطلاعات کارت اشتباه است";
            case 132:
            case 133:
                return"   کارت مسدود یا منقضی می باشد";
            case 140:
                return" زمان مورد نظر به پایان رسیده است";
            case 200:
            case 201:
            case 202:
                return" مبلغ بیش از سقف مجاز";
            case 166:
                return" بانک صادر کننده مجوز انجام  تراکنش را صادر نکرده";
            case 150:
            default:
                return " خطا بانک  $resultCode";
        }
    }
    private function messeg2($result) {
        switch ($result) {
            case '-20':
                return "در درخواست کارکتر های غیر مجاز وجو دارد";
            case '-30':
                return " تراکنش قبلا برگشت خورده است";
            case '-50':
                return " طول رشته درخواست غیر مجاز است";
            case '-51':
                return " در در خواست خطا وجود دارد";
            case '-80':
                return " تراکنش مورد نظر یافت نشد";
            case '-81':
                return " خطای داخلی بانک";
            case '-90':
                return " تراکنش قبلا تایید شده است";
        }
    }
}