<?php
namespace app\modules\sms;
use Yii;
class Module extends \yii\base\Module {
    public $controllerNamespace = 'app\modules\sms\controllers';
    public function init() {
        parent::init();
        Yii::configure($this, require __DIR__ . '/config.php');
    }
}