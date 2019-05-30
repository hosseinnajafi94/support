<?php
namespace app\config\widgets;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
class GridView extends \yii\grid\GridView {
    public $dataColumnClass = 'app\config\widgets\DataColumn';
    public $filterPosition  = self::FILTER_POS_HEADER;
    public function init() {
        foreach ($this->columns as &$column) {
            if (is_array($column) && isset($column['attribute']) && strpos($column['attribute'], 'id_') === 0 && !isset($column['value'])) {
                $column['format'] = 'raw';
                $attribute = $column['attribute'];
                $pat = ArrayHelper::remove($column, 'pattern', '');
                $urlAr = ArrayHelper::remove($column, 'url', '');
                $url = str_replace(['%7B', '%7D'], ['{', '}'], Url::to($urlAr));
                $column['value'] = function ($model) use($attribute, $pat, $url, $urlAr) {
                    $col = substr($attribute, 3);
                    $row = $model->$col;
                    preg_match_all('/[*{]+[a-zA-Z0-9.]+[*}]/', $pat, $match);
                    $match = str_replace(['{', '}'], '', $match[0]);
                    foreach ($match as $r) {
                        $value = ArrayHelper::getValue($row, $r, '');
                        $pat = str_replace('{' . $r . '}', $value, $pat);
                    }
                    preg_match_all('/[*{]+[a-zA-Z0-9._]+[*}]/', $url, $match);
                    $match = str_replace(['{', '}'], '', $match[0]);
                    foreach ($match as $r) {
                        $value = ArrayHelper::getValue($row, $r, '');
                        $url = str_replace('{' . $r . '}', $value, $url);
                    }
                    return $urlAr ? Html::a($pat, $url, ['class' => 'view']) : $pat;
                };
            }
            else if (is_array($column) && isset($column['attribute']) && strpos($column['attribute'], '_id') !== false && !isset($column['value'])) {
                $column['format'] = 'raw';
                $attribute = $column['attribute'];
                $pat = ArrayHelper::remove($column, 'pattern', '');
                $urlAr = ArrayHelper::remove($column, 'url', '');
                $url = str_replace(['%7B', '%7D'], ['{', '}'], Url::to($urlAr));
                $column['value'] = function ($model) use($attribute, $pat, $url, $urlAr) {
                    $col = substr($attribute, 0, -3);
                    $row = $model->$col;
                    preg_match_all('/[*{]+[a-zA-Z0-9.]+[*}]/', $pat, $match);
                    $match = str_replace(['{', '}'], '', $match[0]);
                    foreach ($match as $r) {
                        $value = ArrayHelper::getValue($row, $r, '');
                        $pat = str_replace('{' . $r . '}', $value, $pat);
                    }
                    preg_match_all('/[*{]+[a-zA-Z0-9._]+[*}]/', $url, $match);
                    $match = str_replace(['{', '}'], '', $match[0]);
                    foreach ($match as $r) {
                        $value = ArrayHelper::getValue($row, $r, '');
                        $url = str_replace('{' . $r . '}', $value, $url);
                    }
                    return $urlAr ? Html::a($pat, $url, ['class' => 'view']) : $pat;
                };
            }
        }
        $this->formatter = new Formatter();
        parent::init();
    }
}