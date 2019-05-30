<?php
use yii\helpers\Html;
use app\config\widgets\ActiveForm;
/* @var $this  \yii\web\View */
/* @var $form  \app\config\widgets\ActiveForm */
/* @var $model \app\modules\users\models\VML\LoginVML */
$this->title = Yii::t('users', 'Login');
?>
<div class="site-auth-login">
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'username', [
        'options' => ['class' => 'form-group has-feedback'],
        'inputTemplate' => "{input}<i class='glyphicon glyphicon-user form-control-feedback'></i>",
    ])->label(false)->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('username')]) ?>
    <?= $form->field($model, 'password', [
        'options' => ['class' => 'form-group has-feedback'],
        'inputTemplate' => "{input}<i class='glyphicon glyphicon-lock form-control-feedback'></i>",
    ])->label(false)->passwordInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('password')]) ?>
    <?= $form->field($model, 'captcha')->label(false)->captcha(['placeholder' => $model->getAttributeLabel('captcha')]) ?>
    <label><?= $form->field($model, 'rememberMe')->checkbox() ?></label>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('users', 'Login'), ['class' => 'btn btn-lg btn-default btn-block']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>