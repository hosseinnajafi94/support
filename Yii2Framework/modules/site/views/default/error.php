<?php
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */
use yii\helpers\Html;
$this->params['breadcrumbs'][] = $name;
?>
<div class="site-default-error">
    <div class="box">
        <div class="box-header"><?= $name ?></div>
        <div class="alert alert-danger">
            <?= nl2br(Html::encode(Yii::t('app', $message))) ?>
        </div>
    </div>
</div>