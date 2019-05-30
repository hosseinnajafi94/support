<?php
namespace app\config\widgets;
use app\config\components\functions;
class ArrayHelper extends \yii\helpers\ArrayHelper {
    public static function getColumnJdate($array, $name) {
        $data = [];
        foreach ($array as $row) {
            $data[] = functions::tojdate($row[$name]);
        }
        return $data;
    }
    public static function getColumnInt($array, $name) {
        $data = [];
        foreach ($array as $row) {
            $data[] = (int) $row[$name];
        }
        return $data;
    }
}