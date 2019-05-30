<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\config\widgets\ActiveForm;
use app\config\components\functions;
use app\modules\users\models\SRL\UsersSRL;
/* @var $this yii\web\View */
/* @var $model \app\modules\ticketing\models\DAL\Tickets */
/* @var $answer \app\modules\ticketing\models\VML\TicketsVML */
Url::remember();
$this->params['breadcrumbs'][] = ['label' => Yii::t('ticketing', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->title;
$user                          = UsersSRL::findModel(Yii::$app->user->id);
$isAdmin                       = $user->group->is_admin == 1;
?>
<div class="tickets-view">
    <div class="box">
        <div class="box-header">
            <span class="pull-left"><?= $model->status->title ?></span>
            <p><?= $model->title ?></p>
            <span># <?= $model->id ?></span> / 
            <span>بخش: <?= $model->support->title ?></span>
        </div>
        <p>
            <?= Html::a(Yii::t('ticketing', 'Create'), ['create'], ['class' => 'btn btn-sm btn-success']) ?>
            <?= Html::a(Yii::t('ticketing', 'Answer'), null, ['class' => 'btn btn-sm btn-primary', 'onclick' => "$('#answer').slideToggle();"]) ?>
            <?= $isAdmin && $model->status_id != 4 ? Html::a(Yii::t('ticketing', 'Close'), ['delete', 'id' => $model->id], ['class' => 'btn btn-sm btn-danger', 'data' => ['confirm' => Yii::t('ticketing', 'Are you sure you want to delete this item?'), 'method' => 'post']]) : '' ?>
        </p>
        <div id="answer" style="display: none;margin-bottom: 15px;background: #EEE;padding: 15px;box-shadow: 0px 0px 2px #AAA inset;">
            <?php $form                          = ActiveForm::begin(); ?>
            <?= $form->field($answer, 'message')->textarea(['rows' => 6]) ?>
            <?= $form->field($answer, 'file')->fileInput() ?>
            <div>
                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-sm btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <?php
        /* @var $messages app\modules\ticketing\models\DAL\TicketsMessages[] */
        $messages                      = $model->getTicketsMessages()->orderBy(['id' => SORT_DESC])->all();
        foreach ($messages as $index => $message) {
            $sender = $message->sender;
            ?>
            <div style="background: <?= $sender->id != Yii::$app->user->id ? 'rgba(0, 255, 0, 0.1)' : '#fff' ?>;padding: 15px 15px 0;box-shadow: 0px 0px 4px #AAA;margin-top: 15px;">
                <div><?= $message->message ?></div>
                <br/>
                <?php
                if ($isAdmin) {
                    ?>
                    <a class="view" href="<?= Url::to(['/users/users/view', 'id' => $sender->id]) ?>"><?= $sender->fname . ' ' . $sender->lname ?></a>
                    <?php
                }
                else {
                    ?>
                    <label><?= $sender->fname . ' ' . $sender->lname ?></label>
                    <?php
                }
                ?>
                <label dir="ltr"><?= functions::tojdatetime($message->datetime) ?></label>
                <?php
                /* @var $attachments app\modules\ticketing\models\DAL\TicketsMessagesAttachments[] */
                $attachments = $message->getTicketsMessagesAttachments()->orderBy(['id' => SORT_ASC])->all();
                foreach ($attachments as $attachment) {
                    ?>
                    <?= Html::a('<label class="label label-default" style="cursor: pointer;">' . Yii::t('app', 'Download File') . '</label>', '@web/uploads/tickets/' . $attachment->file, ['target' => '_blank']) ?>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        ?>
    </div>
</div>