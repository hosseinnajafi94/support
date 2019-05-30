<?php
use yii\helpers\Html;
use app\config\widgets\ActiveForm;
/* @var $this  \yii\web\View */
/* @var $form  \app\config\widgets\ActiveForm */
/* @var $model \app\modules\users\models\VML\UsersGroupsVML */
?>
<div class="users-groups-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box">
        <div class="box-header"><?= Yii::t('app', $model->id ? 'Update' : 'Create') ?></div>
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'is_admin')->checkbox() ?>
                <?= $form->field($model, 'is_marketer')->checkbox() ?>
                <?= $form->field($model, 'is_installer')->checkbox() ?>
                <?= $form->field($model, 'is_sales_manager')->checkbox() ?>
                <?= $form->field($model, 'is_customer')->checkbox() ?>
                <?= $form->field($model, 'is_support')->checkbox() ?>
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
$this->registerCss('.checkbox input[type="checkbox"] {visibility: visible;}');
