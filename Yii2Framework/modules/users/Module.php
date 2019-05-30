<?php
namespace app\modules\users;
use Yii;
class Module extends \yii\base\Module {
    public $controllerNamespace = 'app\modules\users\controllers';
    public function init() {
        parent::init();
        Yii::configure($this, require __DIR__ . '/config.php');
    }
}