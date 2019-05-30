<?php
/* @var $this yii\web\View */
/* @var $model \app\modules\users\models\VML\UsersGroupsVML */
$this->params['breadcrumbs'][] = ['label' => Yii::t('users', 'Users Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>
<div class="users-groups-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>