<?php
use app\config\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model \app\modules\coding\models\DAL\Hesabha */
$this->params['breadcrumbs'][] = ['label' => Yii::t('coding', 'Hesabha'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
?>
<div class="hesabha-view">
    <div class="box">
        <div class="table-responsive">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'id_p1',
                        'pattern'   => '{p1.name1}',
                        'url'       => ['/coding/tcoding/view', 'id' => '{id}'],
                        'visible'   => $model->id_p1 > 0
                    ],
                    [
                        'attribute' => 'id_p3',
                        'label'     => Yii::t('coding', 'NoeDaryaftPardakht'),
                        'pattern'   => '{name1}',
                        'url'       => ['/coding/tcoding/view', 'id' => '{id}'],
                        'visible'   => $model->id_p3 > 0
                    ],
                    [
                        'attribute' => 'id_user1',
                        'label'     => Yii::t('coding', 'Id User'),
                        'pattern'   => '{fname} {lname}',
                        'url'       => ['/users/users/view', 'id' => '{id}']
                    ],
                    'bed:toman',
                    'bes:toman',
                    // 'mab:toman',
                    'desc1:ntext',
                    'desc2:ntext',
                    [
                        'attribute' => 'name1',
                        'label' => Yii::t('coding', 'Shomareh Check')
                    ],
                    [
                        'attribute' => 'date1',
                        'format' => 'jdate',
                        'label' => Yii::t('coding', 'Tarikh Sar Resid')
                    ],
                    'datetime:jdatetime',
                ],
            ]) ?>
        </div>
    </div>
</div>