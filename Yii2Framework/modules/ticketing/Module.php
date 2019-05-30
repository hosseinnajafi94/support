<?php
namespace app\modules\ticketing;
use Yii;
class Module extends \yii\base\Module {
    public $controllerNamespace = 'app\modules\ticketing\controllers';
    public function init() {
        parent::init();
        Yii::configure($this, require __DIR__ . '/config.php');
    }
}