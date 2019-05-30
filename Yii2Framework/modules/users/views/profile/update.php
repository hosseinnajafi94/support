<?php
use yii\helpers\Html;
use app\config\widgets\ActiveForm;
/* @var $this  \yii\web\View */
/* @var $form  \app\config\widgets\ActiveForm */
/* @var $model \app\modules\users\models\VML\UsersVML */
$this->params['breadcrumbs'][] = ['label' => Yii::t('users', 'Profile'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="profile-password box">
    <?php $form                          = ActiveForm::begin(); ?>
    <div class="box-header"><?= Yii::t('app', 'Update') ?></div>
    <div class="row">
        <div class="col-md-4 col-xs-12">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
            <?= $form->field($model, 'fname')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'lname')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
        </div>
        <div class="col-md-4 col-xs-12">
            <?= $form->field($model, 'mobile1')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
            <?= $form->field($model, 'mobile2')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
            <?= $form->field($model, 'phone1')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
            <?= $form->field($model, 'phone2')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
        </div>
        <div class="col-md-4 col-xs-12">
            <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>
        </div>
    </div>
    <div class="box-footer">
        <?= Html::a(Yii::t('app', 'Return'), ['index'], ['class' => 'btn btn-sm btn-warning btn-return']) ?>
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-sm btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>