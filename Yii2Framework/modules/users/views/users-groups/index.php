<?php
use yii\helpers\Html;
use app\config\widgets\GridView;
/* @var $this yii\web\View */
/* @var $model yii\data\ActiveDataProvider */
$this->params['breadcrumbs'][] = Yii::t('users', 'Users Groups');
?>
<div class="users-groups-index">
    <div class="box">
        <div class="box-header"><?= Yii::t('users', 'Users Groups') ?></div>
        <p>
            <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-sm btn-success']) ?>
        </p>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $model,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'title',
                    'is_admin:bool',
                    'is_marketer:bool',
                    'is_installer:bool',
                    'is_sales_manager:bool',
                    'is_customer:bool',
                    'is_support:bool',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]) ?>
        </div>
    </div>
</div>