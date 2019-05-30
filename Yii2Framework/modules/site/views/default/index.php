<?php
use app\assets\SiteAsset;
use app\config\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $settings \app\modules\site\models\DAL\SiteSettings */
$settings = Yii::$app->controller->settings;
$this->title = Yii::t('site', 'Search and reserve rooms');
?>
<div class="container">
    <div class="box box-warning">
        <br />
        <div class="cat-tab-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <ul class="nav panel-tabs">
                        <li class="tablist active">
                            <a href="#tab1" data-toggle="tab" aria-expanded="false">
                                <?= Yii::t('site', 'Search and reserve rooms') ?>
                            </a>
                        </li>
                        <li class="tablist">
                            <a href="#tab2" data-toggle="tab" aria-expanded="false">
                                <?= Yii::t('site', 'Track previous reservations') ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane animated fadeInUp active" id="tab1">
                        <h2><?= Yii::t('site', 'Search and reserve rooms') ?></h2>
                        <div class="text-p">
                            <p><?= nl2br($settings->toz_1) ?></p>
                            <div style="border-top: 1px dashed #AAA;margin: 30px 0;"></div>
                            <div class="col-md-3 col-sm-12 col-xs-12 pull-right"></div>
                            <div class="col-md-6 col-sm-12 col-xs-12 form-horizontal">
                                <div class="form-group">
                                    <label class="col-md-4 col-sm-4 pull-right control-label" style="text-align: left;"><?= Yii::t('site', 'Entry date') ?></label>
                                    <div class="col-md-8 col-sm-8">
                                        <input type="text" class="form-control" id="login_date" name="login_date"/>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="col-md-4 col-sm-4 pull-right control-label" style="text-align: left;"><?= Yii::t('site', 'Date of departure') ?></label>
                                    <div class="col-md-8 col-sm-8">
                                        <input type="text" class="form-control" id="exit_date" name="exit_date"/>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div style="border-top: 1px dashed #AAA;margin: 30px 0;"></div>
                            <a class="btn btn-block btn-danger" id="Search"><?= Yii::t('site', 'Search and reserve ( please click ...)') ?></a>
                        </div>
                        <br/>
                        <div style="display: none;padding: 15px;margin-bottom: 15px;border: 1px solid #992122;background: rgba(255,0,0,0.1);" id="error-message"></div>
                        <div id="tableslist" class="hidden"></div>
                    </div>
                    <div class="tab-pane animated fadeInDown" id="tab2">
                        <div class="row">
                            <div class="col-md-12">
                                <h2><?= Yii::t('site', 'Track previous reservations') ?></h2>
                                <div class="text-p">
                                    <p><?= nl2br($settings->toz_1) ?></p>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><?= Yii::t('site', 'Entry date') ?></label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="tracking_login_date"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><?= Yii::t('site', 'National Code') ?></label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="tracking_code_meli"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <a class="btn btn-block btn-danger" id="Tracking"><?= Yii::t('site', 'Track reservation ( please click ...)') ?></a>
                                </div>
                                <br/>
                                <div style="display: none;padding: 15px;margin-bottom: 15px;border: 1px solid #992122;background: rgba(255,0,0,0.1);" id="error-message2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
ActiveForm::begin(['id' => 'form-info', 'action' => ['info']]);
ActiveForm::end();
ActiveForm::begin(['id' => 'pay-form', 'action' => ['pay'], 'method' => 'get']);
ActiveForm::end();
$this->registerCss(".Select {cursor: pointer;}");
$this->registerJsFile('@web/themes/site/Theme/js/HomeIndex.js', ['depends' => SiteAsset::className()]);