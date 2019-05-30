<?php
namespace app\modules\site;
use Yii;
class Module extends \yii\base\Module {
    public $controllerNamespace = 'app\modules\site\controllers';
    public function init() {
        parent::init();
        Yii::configure($this, require __DIR__ . '/config.php');
    }
}