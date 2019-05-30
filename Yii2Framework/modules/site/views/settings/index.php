<?php
use yii\helpers\Html;
use app\config\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\site\models\DAL\SiteSettings */
$this->params['breadcrumbs'][] = Yii::t('site', 'Site Settings');
?>
<div class="site-settings-index">
    <div class="box">
        <?php $form = ActiveForm::begin(); ?>
        <div class="box-header"><?= Yii::t('site', 'Site Settings') ?></div>
        <?= $form->errorSummary($model, ['class' => 'alert alert-danger']) ?>
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab0" data-toggle="tab"><?= Yii::t('site', 'Site Settings') ?></a></li>
            <li><a href="#tab1" data-toggle="tab"><?= Yii::t('site', 'Enamad & Samandehi') ?></a></li>
            <li><a href="#tab2" data-toggle="tab"><?= Yii::t('site', 'Contacts') ?></a></li>
            <li><a href="#tab3" data-toggle="tab"><?= Yii::t('site', 'Gateway') ?></a></li>
            <li><a href="#tab4" data-toggle="tab"><?= Yii::t('site', 'Email & Sms') ?></a></li>
            <li><a href="#tab5" data-toggle="tab"><?= Yii::t('site', 'Sales & Support') ?></a></li>
        </ul>
        <div class="tab-content">
            <div id="tab0" class="tab-pane active">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'logo')->fileInput() ?>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'favicon')->fileInput()->hint('سایز تصویر 16 پیکسل در 16 پیکسل') ?>
                    </div>
                </div>
                <?= $form->field($model, 'subtitle1')->textarea(['maxlength' => true]) ?>
                <?= $form->field($model, 'subtitle2')->textarea(['maxlength' => true]) ?>
            </div>
            <div id="tab1" class="tab-pane">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <?= $form->field($model, 'enamad')->textarea(['rows' => 6, 'dir' => 'ltr']) ?>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <?= $form->field($model, 'samandehi')->textarea(['rows' => 6, 'dir' => 'ltr']) ?>
                    </div>
                </div>
            </div>
            <div id="tab2" class="tab-pane">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'mobile1')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
                        <?= $form->field($model, 'mobile2')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
                        <?= $form->field($model, 'mobile3')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'phone1')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
                        <?= $form->field($model, 'phone2')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
                        <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
            <div id="tab3" class="tab-pane">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'default_gateway')->select2([1 => 'ملت', 2 => 'ایران کیش', 3 => 'زرین پال']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">ملت</div>
                            <div class="panel-body">
                                <?= $form->field($model, 'mellat_terminal')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
                                <?= $form->field($model, 'mellat_username')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
                                <?= $form->field($model, 'mellat_password')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">ایران کیش</div>
                            <div class="panel-body">
                                <?= $form->field($model, 'irankish_merchant_id')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
                                <?= $form->field($model, 'irankish_sha1Key')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">زرین پال</div>
                            <div class="panel-body">
                                <?= $form->field($model, 'zarinpal_merchant_id')->textInput(['maxlength' => true, 'dir' => 'ltr']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tab4" class="tab-pane">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <?= $form->field($model, 'sms_send_sale')->checkbox() ?>
                        <?= $form->field($model, 'sms_message_sale')->textarea(['rows' => 6]) ?>
                        <?= $form->field($model, 'sms_send_support')->checkbox() ?>
                        <?= $form->field($model, 'sms_message_support')->textarea(['rows' => 6]) ?>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <?= $form->field($model, 'email_send_sale')->checkbox() ?>
                        <?= $form->field($model, 'email_message_sale')->textarea(['rows' => 6]) ?>
                        <?= $form->field($model, 'email_send_support')->checkbox() ?>
                        <?= $form->field($model, 'email_message_support')->textarea(['rows' => 6]) ?>
                    </div>
                </div>
                <div class="alert alert-info">
                    <p><label>[fname]</label>: نام مشتری</p>
                    <p><label>[lname]</label>: نام خانوادگی مشتری</p>
                    <!--<p><label>[mobile]</label>: شماره تلفن همراه مشتری</p>-->
                    <!--<p><label>[idcard]</label>: کد ملی مشتری</p>-->
                    <!--<p><label>[id]</label>: شماره پیگیری</p>-->
                    <!--<p><label>[date1]</label>: تاریخ ورود</p>-->
                    <!--<p><label>[date2]</label>: تاریخ خروج</p>-->
                </div>
            </div>
            <div id="tab5" class="tab-pane">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'tax')->textInput(['dir' => 'ltr'])->hint(Yii::t('site', 'Percent')) ?>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'complications')->textInput(['dir' => 'ltr'])->hint(Yii::t('site', 'Percent')) ?>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'valint1')->textInput(['dir' => 'ltr'])->hint(Yii::t('site', 'Percent')) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'id_user1')->select2($model->users) ?>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'id_user2')->select2($model->users) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-sm btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
$this->registerCss('label > input[type="checkbox"] {visibility: visible;top: 3px;}');
$this->registerJs("
var lastFocus = null;
$(`
#sitesettings-email_message_sale,
#sitesettings-email_message_support,
#sitesettings-sms_message_sale,
#sitesettings-sms_message_support
`).focus(function () {
    lastFocus = $(this);
});
$('.alert-info label').click(function () {
    var text = $(this).text();
    if (lastFocus) {
        var val = lastFocus.val();
        lastFocus.val(val + text);
    }
});
");
