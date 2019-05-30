<?php
use yii\helpers\Html;
use app\config\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $form \app\config\widgets\ActiveForm */
/* @var $model \app\modules\emails\models\VML\EmailsVML */
$this->params['breadcrumbs'][] = ['label' => Yii::t('emails', 'Emails'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('emails', 'Send New Email');
?>
<div class="emails-send box">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-header"><?= Yii::t('emails', 'Send New Email') ?></div>
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <?= $form->field($model, 'receiver_email')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <?= $form->field($model, 'receiver_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
            <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>
        </div>
    </div>
    <div class="box-footer">
        <?= Html::a(Yii::t('app', 'Return'), ['index'], ['class' => 'btn btn-sm btn-warning btn-return']) ?>
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-sm btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>