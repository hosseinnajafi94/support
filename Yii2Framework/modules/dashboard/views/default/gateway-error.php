<?php
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = Yii::t('site', 'Gateway Error');
?>
<div class="container">
    <div class="box box-warning">
        <div class="box-body box-profile">
            <div class="col-md-6 col-md-offset-3 pull-left" style="direction: rtl;">
                <div class="box-comments form-horizontal" style="padding: 15px;">
                    <h3 class="profile-username text-center">
                        <span id="ctl00_ContentPlaceHolder1_Label2">
                            <?= $this->title ?>
                        </span>
                    </h3>
                    <br/>
                    <p class="text-muted text-center"><?= Yii::t('site', 'Gateway Error Desc') ?></p>
                    <br/>
                    <p class="text-muted text-center"><a href="<?= Url::home() ?>"><?= Yii::t('site', 'Home') ?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>