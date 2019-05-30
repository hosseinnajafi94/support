<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $action string */
/* @var $method string */
/* @var $items array */
$this->title = Yii::t('site', 'Start Pay Title');
?>
<div class="container">
    <div id="registerrequest">
        <div class="box box-warning">
            <form id="start-pay" action="<?= $action ?>" method="<?= $method ?>" target="_self" style="margin-top: 25px;min-height: 300px;">
                <?php
                foreach ($items as $name => $value) {
                    echo Html::hiddenInput($name, $value);
                }
                ?>
                <h4 dir="rtl" class="text-center"><?= Yii::t('site', 'Start Pay Desc') ?></h4>
            </form>
        </div>
    </div>
</div>
<?php
$this->registerJs("$('#start-pay').submit();");