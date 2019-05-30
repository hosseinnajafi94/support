<?php
use yii\helpers\Url;
use app\config\components\functions;
/* @var $this yii\web\View */
/* @var $model \app\modules\coding\models\DAL\Reservations */
/* @var $settings \app\modules\site\models\DAL\SiteSettings */
$settings = Yii::$app->controller->settings;
$this->title = Yii::t('site', 'Tracking code and online payment');
?>
<div class="container">
    <div id="registerrequest">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title text-green text-bold"><?= $this->title ?>:</h3>
            </div>
            <div class="box-body box-profile">
                <div class="col-md-6 col-md-offset-3 pull-left" style="direction: rtl;">
                    <div class="box-comments form-horizontal" style="padding: 15px;">
                        <h3 class="profile-username text-center"> <span id="ctl00_ContentPlaceHolder1_Label2"><?= Yii::t('site', 'Your information has been successfully recorded') ?></span></h3>
                        <br/>
                        <p class="text-muted text-center"><?= Yii::t('site', 'Pay Desc {n}', ['n' => $settings->reserve_time]) ?></p>
                        <br/>
                        <div class="form-group">
                            <label class="col-md-4 control-label"><?= Yii::t('site', 'Your interception code') ?></label>
                            <div class="col-md-6">
                                <input type="text" dir="ltr" class="form-control disabled" disabled value="<?= $model->id ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label"><?= Yii::t('site', 'The amount payable') ?></label>
                            <div class="col-md-6">
                                <input type="text" dir="ltr" class="form-control disabled" disabled value="<?= functions::number_format($model->valint9) ?>"/>
                            </div>
                            <label class="col-md-2 control-label"><?= Yii::t('app', 'Toman') ?></label>
                        </div>
                        <a class="btn btn-block btn-danger" href="<?= Url::to(['start-pay', 'n' => $model->name1, 't' => $model->id]) ?>"><?= Yii::t('site', 'Pay online') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>