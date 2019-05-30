<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\config\widgets\GridView;
use app\modules\users\models\SRL\UsersSRL;
/* @var $this yii\web\View */
/* @var $model yii\data\ActiveDataProvider */
Url::remember();
$this->params['breadcrumbs'][] = Yii::t('ticketing', 'Tickets');
$user                          = UsersSRL::findModel(Yii::$app->user->id);
$isAdmin                       = $user->group->is_admin == 1;
?>
<div class="tickets-index">
    <div class="box">
        <div class="box-header"><?= Yii::t('ticketing', 'Tickets') ?></div>
        <p>
            <?= Html::a(Yii::t('ticketing', 'Create'), ['create'], ['class' => 'btn btn-sm btn-success']) ?>
        </p>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $model,
                'rowOptions' => function ($model) {
                    if ($model->sender_id == Yii::$app->user->id) {
                        if ($model->status_id === 3) {
                            return ['class' => 'success'];
                        }
                    }
                    else {
                        if ($model->status_id === 1) {
                            return ['class' => 'danger'];
                        }
                        else if ($model->status_id === 2) {
                            return ['class' => 'warning'];
                        }
                    }
                },
                'columns' => [
                    'id',
                    'title',
                    [
                        'attribute' => 'sender_id',
                        'pattern' => '{fname} {lname}',
                        'url' => $isAdmin ? ['/users/users/view', 'id' => '{id}'] : null
                    ],
                    [
                        'attribute' => 'support_id',
                        'pattern' => '{title}'
                    ],
                    [
                        'attribute' => 'status_id',
                        'pattern' => '{title}'
                    ],
                    'datetime:jdatetime',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {delete}',
                        'buttons' => [
                            'delete' => function ($url, $model) use ($isAdmin) {
                                return $isAdmin && $model->status_id != 4 ? Html::a('<i class="fa fa-fw fa-close"></i>', $url, ['title' => Yii::t('ticketing', 'Close'), 'data' => ['confirm' => Yii::t('ticketing', 'Are you sure you want to delete this item?'), 'method' => 'post']]) : '';
                            }
                        ]
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>