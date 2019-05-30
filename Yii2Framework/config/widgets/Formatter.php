<?php
namespace app\config\widgets;
use Yii;
use yii\helpers\Html;
use app\config\components\functions;
use app\modules\geo\models\SRL\GeoProvincesSRL;
class Formatter extends \yii\i18n\Formatter {
    public $nullDisplay = '';
    public function asJdate($value) {
        if ($value === null || empty($value)) {
            return $this->nullDisplay;
        }
        if (is_numeric($value)) {
            $value = date('Y-m-d', $value);
        }
        $output = functions::tojdate($value);
        return $output == null ? $this->nullDisplay : $output;
    }
    public function asJdatetime($value) {
        if ($value === null || empty($value)) {
            return $this->nullDisplay;
        }
        if (is_numeric($value)) {
            $value = date('Y-m-d H:i:s', $value);
        }
        $output = functions::tojdatetime($value);
        return $output == null ? $this->nullDisplay : '<span dir="ltr">' . $output . '</span>';
    }
    public function asRial($value) {
        if ($value === null || empty($value)) {
            $value = 0;
        }
        return number_format($value) . ($value == 0 ? '' : ' ' . Yii::t('app', 'Rial'));
    }
    public function asToman($value) {
        if ($value === null || empty($value)) {
            $value = 0;
        }
        return number_format($value) . ($value == 0 ? '' : ' ' . Yii::t('app', 'Toman'));
    }
    public function asBool($value) {
        if ($value == 1) {
            return '<i class="fa fa-check text-success"></i>';
        }
        return '<i class="fa fa-times text-danger"></i>';
    }
    public function asProvince($value) {
        try {
            $data = GeoProvincesSRL::findModel($value);
            return $data->title;
        }
        catch (Exception $ex) {
            return $this->nullDisplay;
        }
    }
    public function asImg($value, $path) {
        if ($value === null || empty($value)) {
            return $this->nullDisplay;
        }
        $url = '@web/uploads/' . $path . '/' . $value;
        return Html::img($url, ['class' => 'img-responsive', 'style' => 'max-width: 150px;max-height: 150px;']);
    }
    public function asImgLink($value, $path) {
        if ($value === null || empty($value)) {
            return $this->nullDisplay;
        }
        $url = '@web/uploads/' . $path . '/' . $value;
        return Html::a(Html::img($url, ['class' => 'img-responsive', 'style' => 'max-width: 150px;max-height: 150px;']), $url, ['target' => '_blank']);
    }
    public function asFile($value, $path) {
        if ($value === null || empty($value)) {
            return $this->nullDisplay;
        }
        $url = '@web/uploads/' . $path . '/' . $value;
        return Html::a(Yii::t('app', 'Download File'), $url, ['target' => '_blank']);
    }
    public function asDatediff($date1, $date2) {
        return functions::datediff($date1, $date2) + 1;
    }
    public function asB($value, $category, $true, $false) {
        if ($value === null || empty($value)) {
            return $this->nullDisplay;
        }
        return Yii::t($category, $value == 1 ? $true : $false);
    }
    public function asFew($value) {
        if ($value === null || empty($value)) {
            $value = '';
        }
        return mb_substr($value, 0, 30, 'UTF-8') . (strlen($value) > 30 ? ' ...' : '');
    }
}