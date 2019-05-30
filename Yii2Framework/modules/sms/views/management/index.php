<?php
use yii\helpers\Html;
use app\config\widgets\GridView;
/* @var $this yii\web\View */
/* @var $model yii\data\ActiveDataProvider */
$this->params['breadcrumbs'][] = Yii::t('sms', 'Sms');
?>
<div class="sms-index box">
    <div class="box-header"><?= Yii::t('sms', 'Sms') ?></div>
    <p>
        <?= Html::a(Yii::t('sms', 'Send New Sms'), ['send'], ['class' => 'btn btn-sm btn-success']) ?>
    </p>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $model,
            'columns'      => [
                ['class' => 'yii\grid\SerialColumn'],
                'to_number',
                'message:few',
                'datetime:jdatetime',
                ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
            ],
        ]) ?>
    </div>
</div>