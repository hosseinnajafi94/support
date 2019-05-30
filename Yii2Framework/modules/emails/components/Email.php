<?php
namespace app\modules\emails\components;
use Yii;
use yii\helpers\Url;
use Swift_Message;
use Swift_Attachment;
use Swift_SmtpTransport;
use Swift_Mailer;
use app\modules\site\models\SRL\SiteSettingsSRL;
class Email {
    public static function send($settings, $from_email, $from_name, $to_email, $to_name, $subject, $message_text, $attachments = []) {
        $body = self::body($subject, $message_text);
        $message = Swift_Message::newInstance($subject, $body, 'text/html', 'UTF-8');
        $message->setFrom($from_email, $from_name);
        $message->setTo($to_email, $to_name);
        foreach ($attachments as $attachment) {
            $message->attach(Swift_Attachment::fromPath($attachment));
        }
        $mail = Swift_SmtpTransport::newInstance($settings->server, $settings->port, 'tls');
        $mail->setStreamOptions(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);
        $mail->setUsername($settings->username);
        $mail->setPassword($settings->password);
        $mailer = Swift_Mailer::newInstance($mail);
        $output = $mailer->send($message) > 0;
        return $output;
    }
    private static function body($subject, $message) {
        $site_settings = SiteSettingsSRL::get();
        return "
        <!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
        <html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"" . Yii::$app->language . "\">
            <head>
                <meta http-equiv=\"Content-Type\" content=\"text/html; charset=" . Yii::$app->charset . "\" />
                <title>$subject</title>
                <style>* {font-family: Tahoma;}a {text-decoration: none;cursor: pointer;}#main1 {direction: rtl;font-size: 13px;color: #444;background: #EEE;padding: 50px 0;}#main2 {position: relative;width: 100%;max-width: 500px;margin: 0 auto;}#main3 {width: 100%;max-width: 500px;margin: 0 auto;background: #FFF;border: 1px solid #CCC;border-top: 4px solid #EA4335;}#message {padding: 15px;border-bottom: 1px solid #EEE;}#footer {padding: 15px;}p {margin: 0;}</style>
            </head>
            <body dir=\"rtl\">
                <div id=\"main1\">
                    <div id=\"main2\">
                        <img src=\"" . Url::base(true) . "/uploads/settings/logo/$site_settings->logo\" style=\"float: left;\"/>
                        <div style=\"clear: both;\"></div>
                    </div>
                    <div id=\"main3\">
                        <h3 style=\"padding: 15px;margin: 0;\">$subject</h3>
                        <div id=\"message\">$message</div>
                        <div id=\"footer\"><p style=\"margin-bottom: 15px;\">شما عضوی از سایت $site_settings->title هستید، به همین خاطر این ایمیل به دست شما رسیده است.</p><p><a href=\"" . Url::base(true) . "\">صفحه اصلی سایت</a></p></div>
                    </div>
                </div>
            </body>
        </html>
        ";
    }
}