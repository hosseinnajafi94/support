<?php
use yii\helpers\Html;
use app\config\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $form \app\config\widgets\ActiveForm */
/* @var $model \app\modules\sms\models\VML\SmsVML */
$this->params['breadcrumbs'][] = ['label' => Yii::t('sms', 'Sms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('sms', 'Send New Sms');
?>
<div class="sms-send box">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-header"><?= Yii::t('sms', 'Send New Sms') ?></div>
    <div class="row">
        <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
            <?= $form->field($model, 'receiver')->textInput(['dir' => 'ltr', 'maxlength' => true]) ?>
            <?= $form->field($model, 'message')->textarea(['rows' => 7]) ?>
        </div>
    </div>
    <div class="box-footer">
        <?= Html::a(Yii::t('app', 'Return'), ['index'], ['class' => 'btn btn-sm btn-warning btn-return']) ?>
        <?= Html::submitButton(Yii::t('sms', 'Send'), ['class' => 'btn btn-sm btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>