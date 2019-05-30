<?php
use yii\helpers\Html;
use app\config\widgets\DetailView;
use app\config\widgets\ArrayHelper;
/* @var $this  \yii\web\View */
/* @var $model \app\modules\users\models\DAL\Users */
$this->params['breadcrumbs'][] = ['label' => Yii::t('users', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->fname . ' ' . $model->lname;
?>
<div class="users-view box">
    <div class="box-header"><?= $model->fname . ' ' . $model->lname ?></div>
    <p>
        <?= Html::a(Yii::t('app', 'Return'), ['index'] , ['class' => 'btn btn-sm btn-warning btn-return']) ?>
        <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-sm btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update' , 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete' , 'id' => $model->id], ['class' => 'btn btn-sm btn-danger', 'data' => ['confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'method' => 'post']]) ?>
        <?= Html::a(Yii::t('users', 'Reset Password')  , ['reset-password', 'id' => $model->id], ['class' => 'btn btn-sm btn-default', 'data' => ['confirm' => Yii::t('users', 'Are you sure you want to reset-password this item?'), 'method' => 'post']]) ?>
    </p>
    <div class="table-responsive">
        <?= DetailView::widget([
            'model'      => $model,
            'attributes' => [
                [
                    'attribute' => 'group_id',
                    'pattern' => '{title}',
                    'url' => ['/users/users-groups/view', 'id' => '{id}'],
                ],
                'can_login:bool',
                'username',
                'fname',
                'lname',
                [
                    'visible' => $model->ref_id > 0,
                    'attribute' => 'ref_id',
                    'pattern' => '{fname} {lname}',
                    'url' => ['/users/users/view', 'id' => '{id}'],
                ],
                'email',
                'mobile1',
                'mobile2',
                'phone1',
                'phone2',
                'address',
                [
                    'label' => Yii::t('users', 'Permissions'),
                    'format' => 'raw',
                    'value' => function ($model) {
                        $auth = Yii::$app->authManager;
                        $permissions = $auth->getPermissionsByUser($model->id);
                        $items = [];
                        foreach ($permissions as $name => $permission) {
                            $index = (int) $permission->description;
                            if ($index != 0) {
                                $items[] = [
                                    'index' => $index,
                                    // 'value' => $permission->description,
                                    'value' => str_replace($index . '- ', '', $permission->description),
                                ];
                            }
                        }
                        sort($items);
                        return Html::ul(ArrayHelper::getColumn($items, 'value'));
                    }
                ],
            ],
        ]) ?>
    </div>
</div>