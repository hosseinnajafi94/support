<?php
namespace app\modules\sms\components;
use SoapClient;
use SoapFault;
class SmsIR {
    public static function send($settings, $mobile, $message) {
        try {
            $client = new SoapClient($settings->address);
            $result = $client->SendMessageWithLineNumber([
                'userName'     => $settings->username,
                'password'     => $settings->password,
                'lineNumber'   => $settings->line_number,
                'mobileNos'    => [doubleval($mobile)],
                'messages'     => [$message],
                'sendDateTime' => date("Y-m-d") . "T" . date("H:i:s")
            ]);
            //$tracking_code = result->SendMessageWithLineNumberResult->long;
            return property_exists($result, 'SendMessageWithLineNumberResult') ? true : false;
        }
        catch (SoapFault $ex) {
            $message = $ex->getMessage();
        }
        return false;
    }
}