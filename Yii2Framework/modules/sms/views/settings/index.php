<?php
use yii\helpers\Html;
use app\config\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $form \app\config\widgets\ActiveForm */
/* @var $model \app\modules\sms\models\VML\SmsSettingsVML */
$this->params['breadcrumbs'][] = Yii::t('sms', 'Sms Settings');
?>
<div class="sms-settings-update box">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-header"><?= Yii::t('sms', 'Sms Settings') ?></div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
            <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
            <?= $form->field($model, 'password')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
            <?= $form->field($model, 'line_number')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
        </div>
    </div>
    <div class="box-footer">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-sm btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>