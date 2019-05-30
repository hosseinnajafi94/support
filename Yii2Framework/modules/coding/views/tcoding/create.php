<?php
/* @var $this  \yii\web\View */
/* @var $model \app\modules\coding\models\DTL\TcodingDTL */
$this->params['breadcrumbs'] = $model->breadcrumbs;
?>
<div class="coding-tcoding-create">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>