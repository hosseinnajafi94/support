<?php
namespace app\assets;
use yii\web\AssetBundle;
class SiteAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'themes/default/lib/font-awesome/css/font-awesome.min.css',
//        'themes/default/lib/bootstrap/bootstrap-theme.min.css',
//        'themes/default/lib/bootstrap/bootstrap-rtl.min.css',
//        'themes/default/lib/jquery-confirm/jquery-confirm.min.css',
         'themes/site/Theme/bootstrap-3.3.7/css/bootstrap.css',
        'themes/site/Theme/css/AdminLTE.css',
        'themes/site/Theme/js/jquery_date_picker/bootstrap-datepicker.css',
        'themes/site/Theme/css/megamenu.css',
        'themes/site/Theme/css/tabs.css',
        'themes/site/Theme/css/navebar.css',
        'themes/site/Theme/css/fontiran.css',
        'themes/site/Theme/css/slider.css',
        'themes/site/Theme/css/customized.css',
        'themes/site/Theme/js/iCheck/all.css',
//        'themes/default/css/site.css',
    ];
    public $js = [
        'themes/default/lib/datatables/datatables.all.min.js',
        'themes/default/lib/datatables/plugins/bootstrap/datatables.bootstrap.js',
        'themes/default/lib/jquery-confirm/jquery-confirm.min.js',
        'themes/site/Theme/js/jquery_date_picker/bootstrap-datepicker.js',
        'themes/site/Theme/js/jquery_date_picker/bootstrap-datepicker.fa.js',
        'themes/site/Theme/js/iCheck/icheck.min.js',
        'themes/site/Theme/js/slider.js',
        'themes/site/Theme/js/Common.js',
        'themes/site/Theme/js/jquery.form-validator.min.js',
//        'themes/default/lib/datepicker/pwt-date.js',
//        'themes/default/lib/datepicker/pwt-datepicker.js',
//        'themes/default/js/functions.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}