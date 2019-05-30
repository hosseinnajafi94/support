<?php
use yii\helpers\Html;
use app\config\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model \app\modules\sms\models\DAL\Sms */
$this->params['breadcrumbs'][] = ['label' => Yii::t('sms', 'Sms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->to_number;
?>
<div class="sms-view box">
    <div class="box-header"><?= $model->to_number ?></div>
    <p>
        <?= Html::a(Yii::t('sms', 'Send New Sms'), ['send'], ['class' => 'btn btn-sm btn-success']) ?>
    </p>
    <div class="table-responsive">
        <?= DetailView::widget([
            'model'      => $model,
            'attributes' => [
                'to_number',
                'message:ntext',
                'datetime:jdatetime',
            ],
        ]) ?>
    </div>
</div>