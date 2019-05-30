<?php
use yii\helpers\Html;
use app\config\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $form \app\config\widgets\ActiveForm */
/* @var $model \app\modules\emails\models\VML\EmailsSettingsVML */
$this->params['breadcrumbs'][] = Yii::t('emails', 'Emails Settings');
?>
<div class="emails-settings box">
    <div class="box-header"><?= Yii::t('emails', 'Emails Settings') ?></div>
    <?php $form = ActiveForm::begin() ?>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <?= $form->field($model, 'server')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
            <?= $form->field($model, 'port')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
            <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
            <?= $form->field($model, 'password')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
        </div>
    </div>
    <div class="box-footer"><?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-sm btn-success']) ?></div>
    <?php ActiveForm::end() ?>
</div>