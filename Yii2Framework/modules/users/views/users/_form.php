<?php
use yii\helpers\Html;
use app\config\widgets\ActiveForm;
/* @var $this  \yii\web\View */
/* @var $form  \app\config\widgets\ActiveForm */
/* @var $model \app\modules\users\models\VML\UsersVML */
?>
<div class="users-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box">
        <div class="box-header"><?= Yii::t('app', $model->id ? 'Update' : 'Create') ?></div>
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <?= $form->field($model, 'group_id')->select2($model->_groups) ?>
                <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'fname')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'lname')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'ref_id')->select2($model->_refs) ?>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
                <?= $form->field($model, 'mobile1')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
                <?= $form->field($model, 'mobile2')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
                <?= $form->field($model, 'phone1')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
                <?= $form->field($model, 'phone2')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>
                <?= $form->field($model, 'can_login')->checkbox() ?>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <?= $form->field($model, 'roles')->checkboxList($model->_roles) ?>
            </div>
        </div>
        <div class="box-footer">
            <?= Html::a(Yii::t('app', 'Return'), ['index'], ['class' => 'btn btn-sm btn-warning btn-return']) ?>
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-sm btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$this->registerCss('
    .checkbox label {padding: 0;}
    .checkbox input[type="checkbox"] {visibility: visible;position: relative;top: 4px;margin: 0;}
');
