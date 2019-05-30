<?php
use yii\helpers\Html;
use app\config\widgets\GridView;
/* @var $this \yii\web\View */
/* @var $model \yii\data\ActiveDataProvider */
$this->params['breadcrumbs'][] = Yii::t('emails', 'Emails');
?>
<div class="emails-index box">
    <div class="box-header"><?= Yii::t('emails', 'Emails') ?></div>
    <p>
        <?= Html::a(Yii::t('emails', 'Send New Email'), ['send'], ['class' => 'btn btn-sm btn-success']) ?>
    </p>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $model,
            'columns'      => [
                ['class' => 'yii\grid\SerialColumn'],
                'to_name',
                'to_email',
                'subject',
                'datetime:jdatetime',
                ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
            ],
        ]) ?>
    </div>
</div>