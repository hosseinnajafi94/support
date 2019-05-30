<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\assets\SiteAsset;
use app\config\widgets\Alert;
use app\modules\site\models\SRL\SiteSettingsSRL;
use yii\bootstrap\BootstrapPluginAsset;
use app\config\components\functions;
/* @var $this \yii\web\View */
/* @var $content string */
BootstrapPluginAsset::register($this);
SiteAsset::register($this);
$settings = SiteSettingsSRL::get();
$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="icon" type="image/png" href="<?= Yii::getAlias('@web/uploads/settings/favicon/' . $settings->favicon) ?>"/>
        <link rel="shortcut icon" type="image/ico" href="<?= Yii::getAlias('@web/uploads/settings/favicon/' . $settings->favicon) ?>"/>
        <title><?= $settings->title . ($this->title ? ' / ' . $this->title : '') ?></title>
        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>
        <script>var urlLoading = '<?= Yii::getAlias('@web/themes/default/images/loading.gif') ?>';</script>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <div id="box" style="display: block;">در حال بارگزاری ....<br />لطفا كمی صبر كنید ....</div>
        <div id="wrapper">
            <div id="topnav" class="hidden-print">
                <!-- Static navbar -->
                <nav class="navbar navbar-default navbar-static-top">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div id="navbar" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li class="active"><a href="<?= Url::to(['/site/default/index']) ?>"><i class="fa fa-home homes"></i></a></li>
                                <li><a href="<?= Url::to(['/site/default/index']) ?>"><?= Yii::t('site', 'Home') ?></a></li>
                                <li><a href="<?= Url::to(['/site/default/index', '#' => 'tab2']) ?>"><?= Yii::t('site', 'Track previous reservations') ?></a></li>  
                            </ul>
                            <ul class="nav navbar-nav navbar-left">
                                <li><a href=""><i class="fa fa-phone"></i> <span><?= '' ?></span></a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="container">
                    <div class="col-md-6" style="text-align: right">
                        <div class="logo">
                            <a href="">
                                <img src="<?= Yii::getAlias('@web/uploads/settings/logo/' . $settings->logo) ?>">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 hidden-xs">
                        <div class="logo_data">
                            <div><?= Yii::t('site', 'Time in Tehran') ?></div>
                            <div><?= functions::datestring() ?></div>
                            <div><?= Yii::t('site', 'Clock') ?>: <?= functions::getjtime() ?></div>
                            <br>
                        </div>
                    </div>
                </div>
                <hr />
            </div>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
        <div id="footer" class="hidden-print">
            <div class="container">
                <div class="col-md-5">
                    <div class="bx-header"><h2><?= Yii::t('site', 'Contacts') ?>:</h2></div>
                    <div class="content">
                        <?= nl2br($settings->contact) ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bx-header"><h2><?= Yii::t('site', 'E correspondence') ?>:</h2></div>
                    <div class="content">
                        <?= nl2br($settings->correspondence) ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="bx-header"><h2><?= Yii::t('site', 'Electronic trust') ?></h2></div>
                    <div class="content" style="text-align: center">
                        <?= $settings->enamad ?>
                    </div>
                </div> 
                <div class="col-md-2">
                    <div class="bx-header"><h2><?= Yii::t('site', 'Symbol of the headquarters') ?></h2></div>
                    <div class="content" style="text-align: center">
                        <?= $settings->samandehi ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer_bottom hidden-print">
            <div id="jumbotron">
                <div class="container">
                    <div id="row">
                        <div class="row-fluid">
                            <div class="col-md-8">
                                <a id="back-to-top" href="#" class="btn btn-warning btn-lg back-to-top" role="button" data-toggle="tooltip" data-placement="top" style="display: none;">
                                    <span class="glyphicon glyphicon-chevron-up"></span>
                                </a>
                                <p><?= nl2br($settings->copy_right) ?></p>
                            </div>
                            <div class="col-md-4">
                                <p><a href="https://www.hosseinnajafi.ir/" target="_blank" title="طراحی سایت حرفه ای">طراحی شده توسط</a> حسین نجفی</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>