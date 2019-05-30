<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\config\components\functions;
/* @var $this yii\web\View */
/* @var $model \app\modules\coding\models\DAL\Reservations */
/* @var $settings \app\modules\site\models\DAL\SiteSettings */
$settings = Yii::$app->controller->settings;
$this->title = Yii::t('site', 'Pay Result');
?>
<div class="container">
    <div id="registerrequest">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title text-green text-bold">
                    نتیجه پرداخت:
                </h3>
            </div>
            <div class="box-body box-profile">

                <div class="col-md-12" style="direction: rtl;">
                    <div class="col-md-12">
                        <div class="box-comments" style="margin:0 auto; width:50%;">
                            <img class="profile-user-img img-responsive img-circle" src="<?= Yii::getAlias('@web/themes/site/Theme/images/user.png') ?>" alt="User profile picture">
                            <h3 class="profile-username text-center">نتیجه پرداخت</h3>
                            <ul class="list-group list-group-unbordered" style="padding: 0 15px;">
                                <li class="list-group-item clearfix" style="padding: 10px 15px;">
                                    <b>پیام</b>
                                    <span id="ctl00_ContentPlaceHolder1_l_message" class="pull-left">خطا در پرداخت</span>
                                </li>
                                <li class="list-group-item clearfix" style="padding: 10px 15px;">
                                    <b>کد پیگیری</b>
                                    <span id="ctl00_ContentPlaceHolder1_RefIdLabel" class="pull-left"><?= $model->id ?></span>
                                </li>
                                <li class="list-group-item clearfix" style="padding: 10px 15px;">
                                    <b>شماره پرداخت</b>
                                    <span id="ctl00_ContentPlaceHolder1_RefIdLabel" class="pull-left"><?= $ref ?></span>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>