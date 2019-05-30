<?php
/* @var $this yii\web\View */
/* @var $model \app\modules\users\models\VML\UsersGroupsVML */
$this->params['breadcrumbs'][] = ['label' => Yii::t('users', 'Users Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="users-groups-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>