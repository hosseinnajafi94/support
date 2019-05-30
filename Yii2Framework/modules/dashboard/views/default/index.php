<?php
use yii\helpers\Html;
use app\config\widgets\ActiveForm;
use app\config\components\functions;
use app\modules\coding\models\SRL\TcodingSRL;
/* @var $this yii\web\View */
$this->title = Yii::t('dashboard', 'Dashboard');
?>
<div class="dashboard-default-index">
    <div class="row">
        <div class="col-lg-8">
            <div class="box">
                <div class="box-header">محصولات</div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>شناسه</th>
                                <th>نام محصول</th>
                                <th>مبلغ کل</th>
                                <th>تاریخ ثبت</th>
                                <th>تاریخ پشتیبانی</th>
                                <th>مانده حساب</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (empty($list)) {
                                ?>
                                <tr>
                                    <td colspan="6" style="text-align: center;color: #AAA;">--&nbsp;بدون محتوی&nbsp;--</td>
                                </tr>
                                <?php
                            }
                            /* @var $row \app\modules\coding\models\DAL\Tcoding */
                            foreach ($list as $row) {
                                $support = TcodingSRL::getLastSupport($row->id);
                                $row2    = functions::queryOne("
                                    SELECT (SUM(m1.bed) - SUM(m1.bes)) AS sum
                                    FROM hesabha AS m1
                                    WHERE m1.id_p1 = $row->id
                                    AND m1.id_user1 = $row->id_user1
                                ");
                                ?>
                                <tr>
                                    <td><?= $row->id ?></td>
                                    <td><?= $row->p1->name1 ?></td>
                                    <td><?= functions::toman($row->valint10) ?></td>
                                    <td><?= functions::tojdate($row->date1) ?></td>
                                    <td><?= $support ? functions::tojdate($support->date2) : '' ?></td>
                                    <td><?= functions::toman($row2['sum']) ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box">
                <div class="box-header"><?= Yii::t('app', 'Pay') ?></div>
                <?php $form = ActiveForm::begin(['layout' => 'horizontal']) ?>
                <?= $form->field($model, 'id_p2')->select2($model->ps) ?>
                <?= $form->field($model, 'mab')->textInput(['dir' => 'ltr']) ?>
                <div class="box-footer">
                    <?= Html::submitButton(Yii::t('app', 'Pay'), ['class' => 'btn btn-sm btn-success']) ?>
                </div>
                <?php ActiveForm::end() ?>
            </div>

        </div>
        <div class="col-lg-4">
            <div class="box">
                <div class="box-header">بستانکار</div>
                <div><?= functions::toman($bes) ?></div>
            </div>
            <div class="box">
                <div class="box-header">بدهکار</div>
                <div><?= functions::toman($bed) ?></div>
            </div>
            <div class="box">
                <div class="box-header">درآمد</div>
                <div><?= functions::toman($dar) ?></div>
            </div>
        </div>
    </div>

</div>