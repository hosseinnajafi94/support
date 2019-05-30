<?php
use yii\helpers\Html;
use app\config\widgets\GridView;
use app\modules\coding\models\DAL\Hesabha;
/* @var $this  \yii\web\View */
/* @var $model \yii\data\ActiveDataProvider */
$this->params['breadcrumbs'][] = Yii::t('users', 'Users');
?>
<div class="users-index box">
    <div class="box-header"><?= Yii::t('users', 'Users') ?></div>
    <p>
        <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-sm btn-success']) ?>
    </p>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $model,
            'rowOptions' => function ($model) {
                $row = Hesabha::find()
                ->select(['sum(bed) as bed', 'sum(bes) as bes'])
                ->where(['id_user1' => $model->id])
                ->one();
                $mandeh = $row->bes - $row->bed;
                return ['class' => ($mandeh > 0 ? 'info' : ($mandeh == 0 ? 'success' : 'danger'))];
            },
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'group_id',
                    'pattern' => '{title}',
                    'url' => ['/users/users-groups/view', 'id' => '{id}'],
                ],
                'fname',
                'lname',
                //'can_login:bool',
                //'username',
                //[
                //    'attribute' => 'ref_id',
                //    'pattern' => '{fname} {lname}',
                //    'url' => ['/users/users/view', 'id' => '{id}'],
                //],
                [
                    'label' => 'مانده حساب',
                    'format' => 'toman',
                    'value' => function ($model) {
                        $row = Hesabha::find()
                        ->select(['sum(bed) as bed', 'sum(bes) as bes'])
                        ->where(['id_user1' => $model->id])
                        ->one();
                        $mandeh = $row->bes - $row->bed;
                        return str_replace('-', '', "$mandeh");
                    },
                ],
                [
                    'label' => 'تشخیص',
                    'value' => function ($model) {
                        $row = Hesabha::find()
                        ->select(['sum(bed) as bed', 'sum(bes) as bes'])
                        ->where(['id_user1' => $model->id])
                        ->one();
                        $mandeh = $row->bes - $row->bed;
                        return Yii::t('coding', ($mandeh > 0 ? 'Bes' : ($mandeh == 0 ? 'Zero' : 'Bed')));
                    },
                ],
                [
                    'class' => 'app\config\widgets\ActionColumn',
                    'template' => '{hesabha} {view} {update} {delete}',
                    'buttons' => [
                        'hesabha' => function ($url, $model) {
                            return Html::a('<i class="fa fa-fw fa-bar-chart"></i>', ['/coding/hesabha/index', 'id_user1' => $model->id], ['class' => 'view', 'title' => 'حساب ها']);
                        }
                    ]
                ],
            ],
        ]) ?>
    </div>
</div>