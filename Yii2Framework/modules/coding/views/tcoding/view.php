<?php
use app\config\widgets\DetailView;
/* @var $this  \yii\web\View */
/* @var $model \app\modules\coding\models\DTL\TcodingDTL */
$this->params['breadcrumbs'] = $model->breadcrumbs;
?>
<div class="tcoding-view">
    <div class="box">
        <div class="box-header"><?= $model->title ?></div>
        <p>
            <?= implode("\n", $model->buttons) ?>
        </p>
        <div class="table-responsive">
            <?= DetailView::widget([
                'model'      => $model->model,
                'attributes' => $model->columns,
            ]) ?>
        </div>
    </div>
</div>