<?php
/* @var $this yii\web\View */
/* @var $model \app\modules\coding\models\DAL\Reservations */
/* @var $ref string */
$this->title = Yii::t('site', 'Pay Result');
?>
<div id="registerrequest">
    <div class="box">
        <div class="box-header">نتیجه پرداخت:</div>
        <ul class="list-group list-group-unbordered">
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
    </div>
</div>