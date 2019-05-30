<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\config\components\functions;
/* @var $this yii\web\View */
/* @var $model \app\modules\coding\models\DAL\Reservations */
/* @var $settings \app\modules\site\models\DAL\SiteSettings */
$settings    = Yii::$app->controller->settings;
$this->title = Yii::t('site', 'Factor');
?>
<div class="container">
    <div id="registerrequest">
        <div class="box box-warning">
            <br />
            <div class="alert-success hidden-print" style="direction: rtl;text-align: center;padding: 15px;margin: 0 25px;"><span>پرداخت شما با موفقیت انجام شد.</span></div>
            <div class="invoice" id="invoice" style="border: #B1B1B1 2px solid">
                <div class="row" style="margin: 0;">
                    <div class="col-md-4" style="text-align: right; direction: rtl; background-color: #EDEDED">
                        <h5>شماره پیگیری :  <span id="ctl00_ContentPlaceHolder1_l_id"><?= $model->id ?></span></h5>
                    </div>
                    <div class="col-md-4" style="text-align: right; direction: rtl; background-color: #EDEDED">
                        <h5>
                            تاریخ رزور:
                            <span id="ctl00_ContentPlaceHolder1_l_date_rzerv"><?= functions::datestring($model->date1) ?></span>
                        </h5>
                    </div>
                    <div class="col-md-4" style="text-align: right; direction: rtl; background-color: #EDEDED">
                        <h5>&nbsp;</h5>
                    </div>
                </div>
                <table class="table table-hover table-striped" style="direction: rtl">
                    <tbody>
                        <tr>
                            <th style="width: 10px" align="center">ردیف</th>
                            <th colspan="3" class="text-right">شرح</th>
                            <th style="width:150px;text-align: right;">جمع کل</th>
                        </tr>
                        <tr>
                            <td align="center">1</td>
                            <td colspan="3">
                                تاریخ ورود: <span id="ctl00_ContentPlaceHolder1_l_date_start"><?= functions::datestring($model->date1) ?></span><br>
                                تاریخ خروج: <span id="ctl00_ContentPlaceHolder1_l_date_start"><?= functions::datestring($model->date2) ?></span><br>
                                مدت اقامت <span id="ctl00_ContentPlaceHolder1_l_time_kol"><?= functions::datediffPlusOne($model->date1, $model->date2) ?></span>
                            </td>
                            <td align="right">
                                <span id="ctl00_ContentPlaceHolder1_l_mab_kol"><?= functions::toman($model->valint4) ?></span>
                            </td>
                        </tr>
                        <tr style="color: red;font-weight: bold;">
                            <td colspan="4" align="left">تخفیف:</td>
                            <td align="right">
                                <span id="ctl00_ContentPlaceHolder1_l_mab_m"><?= functions::toman($model->valint5) ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="left">مالیات:</td>
                            <td align="right">
                                <span id="ctl00_ContentPlaceHolder1_l_mab_m"><?= functions::toman($model->valint7) ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="left">عوارض:</td>
                            <td align="right">
                                <span id="ctl00_ContentPlaceHolder1_l_mab_a"><?= functions::toman($model->valint8) ?></span>
                            </td>
                        </tr>
                        <tr class="text-bold" style="background-color: #EDEDED">
                            <td align="left">&nbsp;</td>
                            <td align="left">مبلغ قابل پرداخت</td>
                            <td align="left"> <span id="ctl00_ContentPlaceHolder1_l_mab_harf"><?= functions::number_word($model->valint9) . ' ' . Yii::t('app', 'Toman') ?></span></td>
                            <td align="left">به عدد:</td>
                            <td align="right">
                                <span id="ctl00_ContentPlaceHolder1_l_khales"><?= functions::toman($model->valint9) ?></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <div class="text-green text-bold" style="text-align: right; direction: rtl; font-size: 16px; line-height: 1.6em">اطلاعات پرداخت صورتحساب:</div>
                <table class="table table-hover table-striped" style="direction: rtl">
                    <tbody>
                        <tr>
                            <th>تاریخ واریز</th>
                            <th>شماره فیش واریزی</th>
                            <th>مبلغ واریزی</th>
                        </tr>
                        <tr>
                            <td align="center">
                                <span id="ctl00_ContentPlaceHolder1_l_date_variz"><?= functions::datestring($model->date1) ?></span>
                            </td>
                            <td align="center">
                                <span id="ctl00_ContentPlaceHolder1_l_sh_fish"><?= $ref ?></span>
                            </td>
                            <td align="center">
                                <span id="ctl00_ContentPlaceHolder1_l_mab_variz"><?= functions::toman($model->valint9) ?></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="clearfix"></div>
            </div>
            <div style="padding: 15px 25px 25px 25px;" class="hidden-print">
                <a id="print" class="btn btn-primary">چاپ فاکتور</a>
                <a class="btn btn-warning btn-return" href="<?= Url::to(['index']) ?>">بازگشت</a>
            </div>
        </div>
    </div>
</div>