<?php
namespace app\modules\emails;
use Yii;
class Module extends \yii\base\Module {
    public $controllerNamespace = 'app\modules\emails\controllers';
    public function init() {
        parent::init();
        Yii::configure($this, require __DIR__ . '/config.php');
    }
}