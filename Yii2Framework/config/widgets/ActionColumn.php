<?php
namespace app\config\widgets;
class ActionColumn extends \yii\grid\ActionColumn {
    public function init() {
        $this->buttons['export'] = function ($url, $model, $id) {
            return '<a href="' . $url . '" title="خروجی"><span class="glyphicon glyphicon-export"></span></a>';
        };
        $this->buttons['view'] = function ($url, $model, $id) {
            return '<a href="' . $url . '" class="view" title="جزئیات"><span class="glyphicon glyphicon-eye-open"></span></a>';
        };
        parent::init();
    }
}