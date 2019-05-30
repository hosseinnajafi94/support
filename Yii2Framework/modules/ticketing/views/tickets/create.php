<?php
use yii\helpers\Html;
use app\config\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $form \app\config\widgets\ActiveForm */
/* @var $model \app\modules\ticketing\models\VML\TicketsVML */
$this->params['breadcrumbs'][] = ['label' => Yii::t('ticketing', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('ticketing', 'Create');
?>
<div class="tickets-create">
    <div class="tickets-form">
        <div class="box">
            <div class="box-header"><?= Yii::t('ticketing', 'Create') ?></div>
            <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-md-4 col-xs-12">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4 col-xs-12">
                    <?= $form->field($model, 'support_id')->select2($model->supports) ?>
                </div>
                <?php
                if ($model->user->group->is_admin == 1) {
                    ?>
                    <div class="col-md-4 col-xs-12">
                        <?= $form->field($model, 'receiver_id')->select2($model->receivers) ?>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'file')->fileInput() ?>
            <div class="box-footer">
                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-sm btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>