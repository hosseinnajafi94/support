<?php
use yii\helpers\Html;
use app\config\widgets\GridView;
/* @var $this  \yii\web\View */
/* @var $model \yii\data\ActiveDataProvider */
$this->params['breadcrumbs'][] = Yii::t('coding', 'Hesabha');
$mandeh                        = 0;
$items                         = [];
$items1                         = [];
if ($show) {
    $items = [
        [
            'label'  => 'مانده',
            'format' => 'toman',
            'value'  => function ($model) use (&$mandeh) {
                $mandeh += $model->bed;
                $mandeh -= $model->bes;
                return str_replace('-', '', "$mandeh");
            }
        ],
        [
            'label' => 'تشخیص',
            'value' => function () use (&$mandeh) {
                return Yii::t('coding', ($mandeh > 0 ? 'Bed' : ($mandeh == 0 ? 'Zero' : 'Bes')));
            }
        ],
    ];
}
else {
    $items1 = [
        [
            'attribute' => 'id_user1',
            'label'     => Yii::t('coding', 'Id User'),
            'pattern'   => '{fname} {lname}'
        ],
    ];
}
?>
<div class="hesabha-index">
    <div class="box">
        <div class="box-header"><?= Yii::t('coding', 'Hesabha') ?></div>
        <p>
            <?= Html::a(Yii::t('coding', 'Hesab Create'), ['create'], ['class' => 'btn btn-sm btn-success']) ?>
        </p>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $model,
                'layout' => '{items}',
                'columns'      => array_merge([
                    //['class' => 'yii\grid\SerialColumn'],
                    //'mab',
                    //'desc1:ntext',
                    //'desc2:ntext',
                    //[
                    //    'attribute' => 'id_p1',
                    //    'label'     => Yii::t('coding', 'Sale'),
                    //    'format'    => 'raw',
                    //    'value'     => function ($model) {
                    //        return $model->id_p1 == null || $model->id_p2 != null ? '' : '<i class="fa fa-check text-success"></i>';
                    //    },
                    //    // 'pattern' => '{p1.name1}'
                    //],
                    //[
                    //    'attribute' => 'id_p2',
                    //    'label'     => Yii::t('coding', 'Support'),
                    //    'format'    => 'raw',
                    //    'value'     => function ($model) {
                    //        return $model->id_p2 == null ? '' : '<i class="fa fa-check text-success"></i>';
                    //    },
                    //],
                    'id',
                    [
                        'label' => Yii::t('coding', 'Desc'),
                        'value' => function ($model) {
                            return is_null($model->desc2) || empty($model->desc2) ? $model->desc1 : $model->desc2;
                        }
                    ],
                ],
                $items1,
                [
                    'datetime:jdate',
                    'bed:toman',
                    'bes:toman',
                ], 
                $items,
                [
                    [
                        'class'    => 'app\config\widgets\ActionColumn',
                        'template' => '{view}'
                    ],
                ]),
            ])
            ?>
        </div>
        <?php
        $grid = new GridView(['dataProvider' => $model]);
        echo $grid->renderPager();
        ?>
    </div>
</div>