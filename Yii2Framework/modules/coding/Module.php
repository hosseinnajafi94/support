<?php
namespace app\modules\coding;
use Yii;
class Module extends \yii\base\Module {
    public $controllerNamespace = 'app\modules\coding\controllers';
    public function init() {
        parent::init();
        Yii::configure($this, require __DIR__ . '/config.php');
    }
}