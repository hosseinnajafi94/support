<?php
namespace app\assets;
use yii\web\AssetBundle;
class AdminAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'themes/default/lib/bootstrap/bootstrap-theme.min.css',
        'themes/default/lib/bootstrap/bootstrap-rtl.min.css',
        'themes/default/lib/metismenu/metisMenu.min.css',
        'themes/default/lib/sb-admin/sb-admin-2.css',
        'themes/default/lib/sb-admin/sb-admin-2-rtl.css',
        'themes/default/lib/font-awesome/css/font-awesome.min.css',
        'themes/default/lib/web-fonts-with-css/css/fontawesome-all.min.css',
        'themes/default/lib/datatables/datatables.min.css',
        'themes/default/lib/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css',
        'themes/default/lib/datepicker/pwt-datepicker.css',
        'themes/default/lib/jquery-confirm/jquery-confirm.min.css',
        'themes/default/css/wave.css',
        'themes/default/css/admin.css',
        'themes/default/css/colors.css',
        //'themes/default/css/form.css',
    ];
    public $js = [
        'themes/default/lib/metismenu/metisMenu.min.js',
        'themes/default/lib/sb-admin/sb-admin-2.js',
        'themes/default/lib/datatables/datatables.all.min.js',
        'themes/default/lib/datatables/plugins/bootstrap/datatables.bootstrap.js',
        'themes/default/lib/datepicker/pwt-date.js',
        'themes/default/lib/datepicker/pwt-datepicker.js',
        'themes/default/lib/jquery-confirm/jquery-confirm.min.js',
        'themes/default/js/jquery.cookie.js',
        'themes/default/js/functions.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}