<?php
use yii\helpers\Html;
use app\config\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model \app\modules\emails\models\DAL\Emails */
$this->params['breadcrumbs'][] = ['label' => Yii::t('emails', 'Emails'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->subject;
?>
<div class="emails-view box">
    <div class="box-header"><?= $model->subject ?></div>
    <p>
        <?= Html::a(Yii::t('emails', 'Send New Email'), ['send'], ['class' => 'btn btn-sm btn-success']) ?>
    </p>
    <div class="table-responsive">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'to_email',
                'to_name',
                'subject',
                'message:raw',
                'datetime:jdatetime'
            ],
        ]) ?>
    </div>
</div>