<?php
use app\config\widgets\GridView;
/* @var $this  \yii\web\View */
/* @var $model \app\modules\coding\models\DTL\TcodingDTL */
$this->params['breadcrumbs'] = $model->breadcrumbs;
?>
<div class="coding-tcoding-index">
    <div class="box">
        <div class="box-header"><?= $model->title ?></div>
        <p>
            <?= implode("\n", $model->buttons) ?>
        </p>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $model->dataProvider,
                'columns' => $model->columns
            ]) ?>
        </div>
    </div>
</div>