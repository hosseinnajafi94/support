<?php
use app\config\widgets\ActiveForm;
use app\config\components\functions;
/* @var $this \yii\web\View */
/* @var $model \app\modules\coding\models\DAL\Reservations */
/* @var $settings \app\modules\site\models\DAL\SiteSettings */
$settings = Yii::$app->controller->settings;
$this->title = Yii::t('site', 'Submit reservations info');
?>
<div class="container">
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title text-green text-bold"><?= Yii::t('site', 'Submit reservations info') ?>:</h3>
        </div>
        <div class="box-body box-profile">
            <?php $form = ActiveForm::begin(['layout' => 'horizontal']) ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="box-comments" style="padding: 15px;direction: rtl;">
                        <img class="profile-user-img img-responsive img-circle" src="<?= Yii::getAlias('@web/themes/site/Theme/images/hotel.png') ?>" alt="User profile picture">
                        <h3 class="profile-username text-center"><?= Yii::t('site', 'Room information') ?></h3>
                        <p class="text-muted text-center"><?= Yii::t('site', 'Selected by you') ?></p>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Yii::t('site', 'Room') ?>:</label>
                            <div class="col-sm-6">
                                <input type="text" value="<?= $model->room->name1 ?>" class="form-control disabled" disabled/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Yii::t('site', 'Entry date') ?>:</label>
                            <div class="col-sm-6">
                                <input type="text" value="<?= functions::tojdate($model->date1) ?>" class="form-control disabled" disabled/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Yii::t('site', 'Date of departure') ?>:</label>
                            <div class="col-sm-6">
                                <input type="text" value="<?= functions::tojdate($model->date2) ?>" class="form-control disabled" disabled/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Yii::t('site', 'Staying time') ?>:</label>
                            <div class="col-sm-6">
                                <input type="text" value="<?= $model->days ?>" class="form-control disabled" disabled/>
                            </div>
                            <label class="col-sm-3 control-label"></label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Yii::t('site', 'Price') ?>:</label>
                            <div class="col-sm-6">
                                <input type="text" value="<?= functions::number_format($model->valint4) ?>" class="form-control disabled" disabled/>
                            </div>
                            <label class="col-sm-3 control-label"><?= Yii::t('app', 'Toman') ?></label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Yii::t('site', 'Discount') ?>:</label>
                            <div class="col-sm-6">
                                <input type="text" value="<?= functions::number_format($model->valint5) ?>" class="form-control disabled" disabled/>
                            </div>
                            <label class="col-sm-3 control-label"><?= Yii::t('app', 'Toman') ?></label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Yii::t('site', 'Tax') ?>:</label>
                            <div class="col-sm-6">
                                <input type="text" value="<?= functions::number_format($model->valint7) ?>" class="form-control disabled" disabled/>
                            </div>
                            <label class="col-sm-3 control-label"><?= Yii::t('app', 'Toman') ?></label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Yii::t('site', 'Complications') ?>:</label>
                            <div class="col-sm-6">
                                <input type="text" value="<?= functions::number_format($model->valint8) ?>" class="form-control disabled" disabled/>
                            </div>
                            <label class="col-sm-3 control-label"><?= Yii::t('app', 'Toman') ?></label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?= Yii::t('site', 'The amount payable') ?>:</label>
                            <div class="col-sm-6">
                                <input type="text" value="<?= functions::number_format($model->valint9) ?>" class="form-control disabled" disabled/>
                            </div>
                            <label class="col-sm-3 control-label"><?= Yii::t('app', 'Toman') ?></label>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box-comments" style="direction: rtl;padding: 15px;">
                        <img class="profile-user-img img-responsive img-circle" src="<?= Yii::getAlias('@web/themes/site/Theme/images/user.png') ?>" alt="User profile picture">
                        <h3 class="profile-username text-center"><?= Yii::t('site', 'Submit your information') ?></h3>
                        <p class="text-muted text-center"><?= Yii::t('site', 'Personal information') ?></p>
                        <?= $form->errorSummary($model, ['class' => 'alert alert-danger']) ?>
                        <?= $form->field($model, 'id_p2', ['template' => '{input}', 'options' => ['tag' => false]])->hiddenInput()->label(false) ?>
                        <?= $form->field($model, 'id_p3', ['template' => '{input}', 'options' => ['tag' => false]])->hiddenInput()->label(false) ?>
                        <?= $form->field($model, 'date1', ['template' => '{input}', 'options' => ['tag' => false]])->hiddenInput()->label(false) ?>
                        <?= $form->field($model, 'date2', ['template' => '{input}', 'options' => ['tag' => false]])->hiddenInput()->label(false) ?>
                        <?= $form->field($model, 'name1')->textInput(['dir' => 'ltr', 'class' => 'form-control number']) ?>
                        <?= $form->field($model, 'name2')->textInput() ?>
                        <?= $form->field($model, 'name3')->textInput() ?>
                        <?= $form->field($model, 'name4')->textInput(['dir' => 'ltr', 'class' => 'form-control number']) ?>
                        <?= $form->field($model, 'name5')->textInput(['dir' => 'ltr', 'class' => 'form-control']) ?>
                        <?= $form->field($model, 'valint1')->textInput(['dir' => 'ltr', 'class' => 'form-control number']) ?>
                        <div class="text-center" style="margin: 15px;">
                            <a data-toggle="modal" data-target="#myModal" href="#"><?= Yii::t('site', 'Online reservations terms and conditions') ?></a>
                        </div>
                        <input class="btn btn-block btn-primary" type="submit" value="<?= Yii::t('app', 'Submit') ?>"/>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade text-right" role="dialog" style="direction: rtl;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" style="float: left;margin-top: 5px;">&times;</button>
                <h4 class="modal-title"><?= Yii::t('site', 'Online reservations terms and conditions') ?></h4>
            </div>
            <div class="modal-body">
                <?= nl2br($settings->terms_and_conditions) ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss("
.help-block, .form-control {margin: 0;}
.form-group {margin-bottom: 5px;}
@media (min-width: 768px) {.col-sm-3, .col-sm-6 {float: right;}}
");
