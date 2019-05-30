<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\config\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $form \app\config\widgets\ActiveForm */
/* @var $model \app\modules\coding\models\VML\HesabhaVML */
$this->params['breadcrumbs'][] = ['label' => Yii::t('coding', 'Hesabha'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('coding', 'Hesab Create');
?>
<div class="hesabha-create">
    <div class="hesabha-form">
        <div class="box">
            <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
            <div class="box-header"><?= Yii::t('coding', 'Hesab Create') ?></div>
            <div class="row">
                <div class="col-md-9 col-xs-12">
                    <?= $form->field($model, 'id_p2')->select2($model->ps) ?>
                    <?= $form->field($model, 'id_p3')->select2($model->ps2) ?>
                    <div class="form-group <?= $model->id_p2 ? '' : 'hidden' ?>" id="mandeh">
                        <div class="col-sm-9 col-sm-offset-3">
                            <div>مانده: <span><?= $model->valint1 ?></span></div>
                        </div>
                    </div>
                    <?= $form->field($model, 'id_user1')->select2($model->users) ?>
                    <?= $form->field($model, 'id_user2')->select2($model->users) ?>
                    <?= $form->field($model, 'mab')->textInput(['dir' => 'ltr']) ?>
                    <?= $form->field($model, 'desc2')->textarea(['rows' => 6]) ?>
                    <?= $form->field($model, 'name1')->textInput(['dir' => 'ltr']) ?>
                    <?= $form->field($model, 'date1')->textInput(['dir' => 'ltr', 'class' => 'form-control input-sm text-center datePicker']) ?>
                </div>
            </div>
            <div class="box-footer">
                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-sm btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
$this->registerJs("
$('#hesabhavml-id_p2').change(function () {
    var id = $(this).val();
    $('#mandeh').addClass('hidden');
    $('#hesabhavml-id_user1 option').first().prop('selected', true).trigger('change');
    $('#hesabhavml-id_user2 option').first().prop('selected', true).trigger('change');
    if (id) {
        ajaxget('" . Url::to(['find']) . "', {id}, function (result) {
            $('#mandeh').removeClass('hidden').find('span').html(result[0]);
            $('#hesabhavml-id_user1 option[value=\"' + result[1] + '\"]').prop('selected', true).trigger('change');
            $('#hesabhavml-id_user2 option[value=\"' + result[2] + '\"]').prop('selected', true).trigger('change');
        });
    }
});
");
?>