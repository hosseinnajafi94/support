<?php
namespace app\config\components;
use Yii;
class functions {
    public static function recurse_copy($src, $dst) {
        $dir  = opendir($src);
        @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    recurse_copy($src . '/' . $file, $dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
    public static function deleteDir($dirPath) {
        if (!is_dir($dirPath)) {
            return;
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            }
            else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
    public static function getdatetime($time = null) {
        if ($time != null) {
            return date('Y-m-d H:i:s', $time);
        }
        else {
            return date('Y-m-d H:i:s');
        }
    }
    public static function getdate($time = null) {
        if ($time == null) {
            $time = time();
        }
        return date('Y-m-d', $time);
    }
    public static function getjdate($time = '') {
        return jdf::jdate('Y/m/d', $time);
    }
    public static function getjtime($time = '') {
        return jdf::jdate('H:i:s', $time);
    }
    public static function gettime() {
        return date('H:i:s');
    }
    public static function tojdatetime($in_datetime) {
        if (is_string($in_datetime) && strlen($in_datetime) == 19 && $in_datetime != '0000-00-00 00:00:00') {
            return jdf::jdate('Y/m/d H:i:s', strtotime($in_datetime));
        }
        return null;
    }
    public static function tojdate($in_date) {
        if (is_string($in_date)) {
            if (strlen($in_date) > 10) {
                $in_date = substr($in_date, 0, 10);
            }
            if ($in_date != '0000-00-00') {
                return jdf::jdate('Y/m/d', strtotime($in_date));
            }
        }
        return null;
    }
    public static function togdate($in_date) {
        if (is_string($in_date)) {
            if (strlen($in_date) > 10) {
                $in_date = substr($in_date, 0, 10);
            }
            $jdate = explode('/', $in_date);
            if (count($jdate) == 3) {
                list($year, $month, $day) = jdf::jalali_to_gregorian($jdate[0], $jdate[1], $jdate[2]);
                return $year . '-' . ($month < 10 ? '0' : '') . $month . '-' . ($day < 10 ? '0' : '') . $day;
            }
        }
        return null;
    }
    public static function datestring($in_date = null) {
        if (is_null($in_date)) {
            return jdf::jdate('l d F Y');
        }
        else if (is_string($in_date) && strlen($in_date) == 10 && $in_date != '0000-00-00') {
            return jdf::jdate('l d F Y', strtotime($in_date));
        }
        return null;
    }
    public static function datediff($date1, $date2) {
        $dStart = new \DateTime($date1);
        $dEnd   = new \DateTime($date2);
        $dDiff  = $dStart->diff($dEnd);
        return $dDiff->days;
    }
    public static function datediffPlusOne($date1, $date2) {
        return self::datediff($date1, $date2) + 1;
    }
    public static function httpNotFound($msg = null) {
        throw new \yii\web\NotFoundHttpException($msg ? $msg : Yii::t('app', 'The requested page does not exist.'));
    }
    public static function setSuccessFlash($message = null) {
        Yii::$app->session->setFlash('success', $message ? $message : Yii::t('app', 'Information saved.'));
    }
    public static function setFailFlash($message = null) {
        Yii::$app->session->setFlash('danger', $message ? $message : Yii::t('app', 'Information not saved.'));
    }
    public static function generateConfirmCode() {
        $numbers = range(0, 9);
        shuffle($numbers);
        $code    = '';
        for ($index = 0; $index < 6; $index++) {
            $code .= $numbers[$index];
        }
        return $code;
    }
    public static function queryAll($sql) {
        $query   = new \yii\db\Query();
        $command = $query->createCommand();
        $command->setSql($sql);
        return $command->queryAll();
    }
    public static function queryOne($sql) {
        $rows = self::queryAll($sql);
        return count($rows) > 0 ? $rows[0] : null;
    }
    public static function query($sql) {
        $query   = new \yii\db\Query();
        $command = $query->createCommand();
        $command->setSql($sql);
        return $command->execute();
    }
    public static function number_format($number) {
        return number_format($number, 0, '.', '،');
    }
    public static function number_word($number) {
        $ones = array("", "یک", 'دو&nbsp;', "سه", "چهار", "پنج", "شش", "هفت", "هشت", "نه", "ده", "یازده", "دوازده", "سیزده", "چهارده", "پانزده", "شانزده", "هفده", "هجده", "نونزده");
        $tens = array("", "", "بیست", "سی", "چهل", "پنجاه", "شصت", "هفتاد", "هشتاد", "نود");
        $tows = array("", "صد", "دویست", "سیصد", "چهار صد", "پانصد", "ششصد", "هفتصد", "هشت صد", "نه صد");
        if (($number < 0) || ($number > 999999999)) {
            throw new Exception("Number is out of range");
        }
        $Gn     = floor($number / 1000000);
        /* Millions (giga) */
        $number -= $Gn * 1000000;
        $kn     = floor($number / 1000);
        /* Thousands (kilo) */
        $number -= $kn * 1000;
        $Hn     = floor($number / 100);
        /* Hundreds (hecto) */
        $number -= $Hn * 100;
        $Dn     = floor($number / 10);
        /* Tens (deca) */
        $n      = $number % 10;
        /* Ones */
        $res    = "";
        if ($Gn) {
            $res .= self::number_word($Gn) . " میلیون و ";
        }
        if ($kn) {
            $res .= (empty($res) ? "" : " ") . self::number_word($kn) . " هزار و";
        }
        if ($Hn) {
            $res .= (empty($res) ? "" : " ") . $tows[$Hn] . " و ";
        }
        if ($Dn || $n) {
            if (!empty($res)) {
                $res .= "";
            }
            if ($Dn < 2) {
                $res .= $ones[$Dn * 10 + $n];
            }
            else {
                $res .= $tens[$Dn];
                if ($n) {
                    $res .= " و " . $ones[$n];
                }
            }
        }
        if (empty($res)) {
            $res = "صفر";
        }
        $res = rtrim($res, " و");
        return $res;
    }
    public static function toman($number) {
        return self::number_format($number) . ($number ? ' ' . Yii::t('app', 'Toman') : '');
    }
    public static function getModule($id, $load = true) {
        return Yii::$app->getModule($id, $load);
    }
    public static function getOS($user_agent) {
        $os_platform = "Unknown OS Platform";
        $os_array    = array('/windows nt 10/i' => 'Windows 10', '/windows nt 6.3/i' => 'Windows 8.1', '/windows nt 6.2/i' => 'Windows 8', '/windows nt 6.1/i' => 'Windows 7', '/windows nt 6.0/i' => 'Windows Vista', '/windows nt 5.2/i' => 'Windows Server 2003/XP x64', '/windows nt 5.1/i' => 'Windows XP', '/windows nt 5.0/i' => 'Windows 2000', '/windows xp/i' => 'Windows XP', '/windows me/i' => 'Windows ME', '/win98/i' => 'Windows 98', '/win95/i' => 'Windows 95', '/win16/i' => 'Windows 3.11', '/macintosh|mac os x/i' => 'Mac OS X', '/mac_powerpc/i' => 'Mac OS 9', '/linux/i' => 'Linux', '/ubuntu/i' => 'Ubuntu', '/iphone/i' => 'iPhone', '/ipod/i' => 'iPod', '/ipad/i' => 'iPad', '/android/i' => 'Android', '/blackberry/i' => 'BlackBerry', '/webos/i' => 'Mobile');
        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
                break;
            }
        }
        return $os_platform;
    }
    public static function getBrowser($user_agent) {
        $browser       = "Unknown Browser";
        $browser_array = array(
            '/msie/i'      => 'Internet Explorer',
            '/firefox/i'   => 'Firefox',
            '/safari/i'    => 'Safari',
            '/chrome/i'    => 'Chrome',
            '/edge/i'      => 'Edge',
            '/opera/i'     => 'Opera',
            '/netscape/i'  => 'Netscape',
            '/maxthon/i'   => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i'    => 'Handheld Browser'
        );
        foreach ($browser_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $browser = $value;
                break;
            }
        }
        return $browser;
    }
}