<?php
namespace app\assets;
use yii\web\AssetBundle;
class LoginAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'themes/default/lib/bootstrap/bootstrap-rtl.min.css',
        'themes/default/css/login.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}