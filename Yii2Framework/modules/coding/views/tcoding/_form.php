<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\config\widgets\ActiveForm;
/* @var $this  \yii\web\View */
/* @var $form  \app\config\widgets\ActiveForm */
/* @var $model \app\modules\coding\models\DTL\TcodingDTL */
?>
<div class="tcoding-form">
    <?php $form = ActiveForm::begin(['layout' => 'horizontal']) ?>
    <div class="box">
        <div class="box-header"><?= $model->title ?></div>
        <?php
        switch ($model->idnoe) {
            case $model->module->params['VahedKala']:
                ?>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <?= $form->field($model->viewmodel, 'name1')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <?php
                break;
            case $model->module->params['Kala']:
                ?>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <?= $form->field($model->viewmodel, 'name1')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model->viewmodel, 'id_p1')->select2($model->viewmodel->p1s) ?>
                        <?= $form->field($model->viewmodel, 'valint3')->textInput(['dir' => 'ltr']) ?>
                        <?= $form->field($model->viewmodel, 'valint1')->checkbox() ?>
                        <?= $form->field($model->viewmodel, 'valint2')->checkbox() ?>
                    </div>
                </div>
                <?php
                break;
            case $model->module->params['Discount']:
                $options = [
                    'template' => "{label}<div class=\"col-sm-12\">{input}</div>\n{hint}\n{error}",
                    'errorOptions' => ['class' => 'help-block help-block-error col-sm-12']
                ];
                $this->registerCss('.panel-body .form-group:last-child {margin-bottom: 0;}.checkbox {margin: 0;}.checkbox label {padding: 0;}.checkbox input[type="checkbox"] {position: relative;top: 4px;margin: 0;}');
                ?>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <?= $form->field($model->viewmodel, 'name1')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model->viewmodel, 'date1')->textInput(['dir' => 'ltr', 'class' => 'form-control datePicker text-center']) ?>
                        <?= $form->field($model->viewmodel, 'date2')->textInput(['dir' => 'ltr', 'class' => 'form-control datePicker text-center']) ?>
                        <?= $form->field($model->viewmodel, 'valint1')->select2($model->viewmodel->p1s) ?>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <?= $form->errorSummary($model->viewmodel) ?>
                        <div class="panel panel-default">
                            <div class="panel-heading"><h2 class="panel-title"><?= Yii::t('coding', 'Kala') ?></h2></div>
                            <div class="panel-body" style="overflow-x: hidden;overflow-y: auto;height: 240px;">
                                <?php
                                foreach ($model->viewmodel->models as $index => $row) {
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">
                                            <?= $form->field($row, "[$index]valint1", [
                                                'horizontalCheckboxTemplate' => 
                                                '
                                                    <div class="col-sm-12">
                                                        <div class="checkbox">
                                                            {beginLabel}
                                                                {input}
                                                                {labelTitle}
                                                            {endLabel}
                                                        </div>
                                                        {error}
                                                    </div>
                                                    {hint}
                                                ',
                                            ])->checkbox() ?>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <?= $form->field($row, "[$index]valint2", $options)->textInput(['class' => 'form-control input-sm number', 'dir' => 'ltr'])->label(false) ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                break;
            case $model->module->params['Sale']:
                ?>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <?= $form->field($model->viewmodel, 'id_p1')->select2($model->viewmodel->p1s) ?>
                        <?= $form->field($model->viewmodel, 'valint4')->textInput(['dir' => 'ltr']) ?>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <?= $form->field($model->viewmodel, 'valint1')->textInput(['dir' => 'ltr']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        
                        <?= $form->field($model->viewmodel, 'id_user1')->select2($model->viewmodel->users1) ?>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <?= $form->field($model->viewmodel, 'id_user2')->select2($model->viewmodel->users2) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <?= $form->field($model->viewmodel, 'date1')->textInput(['dir' => 'ltr', 'class' => 'form-control input-sm datePicker text-center']) ?>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <?= $form->field($model->viewmodel, 'date2')->textInput(['dir' => 'ltr', 'class' => 'form-control input-sm datePicker text-center']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <?= $form->field($model->viewmodel, 'valint2')->textInput(['dir' => 'ltr']) ?>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <?= $form->field($model->viewmodel, 'valint3')->textInput(['dir' => 'ltr']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <?= $form->field($model->viewmodel, 'id_p2')->select2($model->viewmodel->p2s) ?>
                        <?= $form->field($model->viewmodel, 'name1')->textarea(['rows' => 6]) ?>
                    </div>
                    <div class="col-md-6 col-xs-12">
                    </div>
                </div>
                <?php
                $this->registerJs("
                    $('#tcodingvml-id_p1').on('change', function () {
                        var id = $('#tcodingvml-id_p1').val();
                        if (id) {
                            ajaxpost('" . Url::to(['product-price']) . "', {id}, function (result) {
                                var isValid = validResult(result);
                                if (isValid) {
                                    $('#tcodingvml-valint4').val(result.val);
                                }
                                findDiscounts();
                            });
                        }
                    });
                    $('#tcodingvml-date1').on('textchange', findDiscounts);
                    function findDiscounts() {
                        var id    = $('#tcodingvml-id_p1').val();
                        var date1 = $('#tcodingvml-date1').val();
                        $('#tcodingvml-id_p2').html('<option value=\"\">لطفا انتخاب کنید</option>');
                        if (id && date1) {
                            ajaxpost('" . Url::to(['discounts']) . "', {id, date1}, function (result) {
                                var isValid = validResult(result);
                                if (!isValid) {
                                    return false;
                                }
                                var options = '<option value=\"\">لطفا انتخاب کنید</option>';
                                $.each(result.list, function (id, name1) {
                                    options += '<option value=\"' + id + '\">' + name1 + '</option>';
                                });
                                $('#tcodingvml-id_p2').html(options);
                            });
                        }
                    }
                ");
                break;
            case $model->module->params['Bedehkari']:
                ?>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <?= $form->field($model->viewmodel, 'id_p1')->select2($model->viewmodel->p1s) ?>
                        <?= $form->field($model->viewmodel, 'id_p2')->select2($model->viewmodel->p2s) ?>
                        <?= $form->field($model->viewmodel, 'date1')->textInput(['dir' => 'ltr', 'class' => 'form-control input-sm text-center datePicker']) ?>
                        <?= $form->field($model->viewmodel, 'date2')->textInput(['dir' => 'ltr', 'class' => 'form-control input-sm text-center datePicker']) ?>
                        <?= $form->field($model->viewmodel, 'date3')->textInput(['dir' => 'ltr', 'class' => 'form-control input-sm text-center datePicker']) ?>
                        <?= $form->field($model->viewmodel, 'valint1')->textInput(['dir' => 'ltr']) ?>
                        <?= $form->field($model->viewmodel, 'name2')->textarea(['rows' => 6]) ?>
                    </div>
                </div>
                <?php
                break;
            case $model->module->params['NoeBedehkari']:
                ?>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <?= $form->field($model->viewmodel, 'name1')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model->viewmodel, 'valint1')->checkbox() ?>
                    </div>
                </div>
                <?php
                break;
            case $model->module->params['NoeDaryaftPardakht']:
                ?>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <?= $form->field($model->viewmodel, 'name1')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <?php
                break;
        }
        ?>
        <div class="box-footer">
            <?= implode("\n", $model->buttons) ?>
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-sm btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>
<?php
$this->registerCss('.checkbox input[type="checkbox"] {visibility: visible;}');
