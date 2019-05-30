<?php
namespace app\modules\dashboard;
use Yii;
class Module extends \yii\base\Module {
    public $controllerNamespace = 'app\modules\dashboard\controllers';
    public function init() {
        parent::init();
        Yii::configure($this, require __DIR__ . '/config.php');
    }
}