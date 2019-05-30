<?php
namespace app\config\components;
use Yii;
use Exception;
use SoapClient;
class DARGAH_SAMAN {
    public static function send($MID, $ResNum, $ResNum1, $Amount, $callback) {
        try {
            $data                = [];
            $data['Amount']      = $Amount;
            $data['MID']         = $MID;
            $data['ResNum']      = $ResNum;
            $data['ResNum1']     = $ResNum1;
            $data['RedirectURL'] = Yii::$app->urlManager->createAbsoluteUrl($callback);
            return [$data, 'https://sep.shaparak.ir/MobilePG/MobilePayment'];
        }
        catch (Exception $exc) {
            return false;
        }
    }
    public static function verify($RefNum, $MID) {
        try {
            $opts   = ['ssl' => ['ciphers' => 'RC4-SHA', 'verify_peer' => false, 'verify_peer_name' => false]];
            $data   = ['encoding' => 'UTF-8', 'verifypeer' => false, 'verifyhost' => false, 'soap_version' => SOAP_1_1, 'trace' => 1, 'exceptions' => 1, 'connection_timeout' => 180, 'stream_context' => stream_context_create($opts)];
            $client = new SoapClient('https://verify.sep.ir/Payments/ReferencePayment.asmx?wsdl', $data);
            return $client->VerifyTransaction($RefNum, $MID);
        }
        catch (Exception $exc) {
            return false;
        }
    }
}