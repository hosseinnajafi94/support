<?php
namespace app\modules\ticketing\models\SRL;
use Yii;
use yii\data\ActiveDataProvider;
use app\modules\ticketing\models\DAL\Tickets;
use app\modules\ticketing\models\DAL\TicketsMessages;
use app\modules\ticketing\models\DAL\TicketsMessagesAttachments;
use app\modules\ticketing\models\VML\TicketsVML;
use app\modules\ticketing\models\VML\AnswerVML;
use app\modules\users\models\SRL\UsersSRL;
use app\config\components\functions;
use yii\web\UploadedFile;
class TicketsSRL {
    /**
     * @return ActiveDataProvider
     */
    public static function index() {
        $query        = Tickets::find()->orderBy(['id' => SORT_DESC]);
        $user = UsersSRL::findModel(Yii::$app->user->id);
        if ($user->group->is_admin == 0) {
            $query->where(['sender_id' => $user->id]);
            $query->orWhere(['receiver_id' => $user->id]);
        }
        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'sort'       => false,
            'pagination' => ['defaultPageSize' => 10]
        ]);
        return $dataProvider;
    }
    /**
     * @return TicketsVML
     */
    public static function newViewModel() {
        $data = new TicketsVML();
        $data->user = UsersSRL::findModel(Yii::$app->user->id);
        return $data;
    }
    /**
     * @param TicketsVML $data
     * @return void
     */
    public static function loadItems($data) {
        if ($data->user->group->is_admin == 1) {
            $data->receivers = UsersSRL::getItems();
        }
        $data->supports  = TicketsSupportsSRL::getItems();
    }
    /**
     * @param TicketsVML $data
     * @param array $postParams Post Params
     * @return bool
     */
    public static function insert($data, $postParams = []) {
        if (!$data->load($postParams)) {
            return false;
        }
        $data->file = UploadedFile::getInstance($data, 'file');
        if (!$data->validate()) {
            return false;
        }
        $model              = new Tickets();
        $model->title       = $data->title;
        $model->type_id     = 1;
        $model->sender_id   = Yii::$app->user->id;
        $model->receiver_id = $data->receiver_id;
        $model->support_id  = $data->support_id;
        $model->status_id   = 1;
        $model->datetime    = functions::getdatetime();
        if (!$model->save()) {
            $data->addErrors($model->getErrors());
            return false;
        }
        $data->id          = $model->id;
        $modelM            = new TicketsMessages();
        $modelM->ticket_id = $model->id;
        $modelM->sender_id = $model->sender_id;
        $modelM->message   = $data->message;
        $modelM->datetime  = $model->datetime;
        if (!$modelM->save()) {
            $model->delete();
            $data->addErrors($modelM->getErrors());
            return false;
        }
        if ($data->file) {
            $path               = 'uploads/tickets/';
            $filename           = uniqid(time(), true) . '.' . $data->file->extension;
            $data->file->saveAs($path . $filename);
            $modelA             = new TicketsMessagesAttachments();
            $modelA->message_id = $modelM->id;
            $modelA->file       = $filename;
            if (!$modelA->save()) {
                $modelM->delete();
                $model->delete();
                $data->addErrors($modelA->getErrors());
                return false;
            }
        }
        return true;
    }
    /**
     * @return Tickets
     */
    public static function findModel($id) {
        $query = Tickets::find()->where(['id' => $id]);
        $user = UsersSRL::findModel(Yii::$app->user->id);
        if ($user->group->is_admin == 0) {
            $query->where(['id' => $id, 'sender_id' => $user->id]);
            $query->orWhere(['id' => $id, 'receiver_id' => $user->id]);
        }
        return $query->one();
    }
    public static function answerViewModel($model) {
        $data        = new AnswerVML();
        $data->model = $model;
        return $data;
    }
    public static function answer($data, $postParams) {
        if (!$data->load($postParams)) {
            return false;
        }
        $data->file = UploadedFile::getInstance($data, 'file');
        if (!$data->validate()) {
            return false;
        }
        $model             = $data->model;
        $modelM            = new TicketsMessages();
        $modelM->ticket_id = $model->id;
        $modelM->sender_id = Yii::$app->user->id;
        $modelM->message   = $data->message;
        $modelM->datetime  = functions::getdatetime();
        if (!$modelM->save()) {
            $data->addErrors($modelM->getErrors());
            return false;
        }
        if ($data->file) {
            $path               = 'uploads/tickets/';
            $filename           = uniqid(time(), true) . '.' . $data->file->extension;
            $data->file->saveAs($path . $filename);
            $modelA             = new TicketsMessagesAttachments();
            $modelA->message_id = $modelM->id;
            $modelA->file       = $filename;
            if (!$modelA->save()) {
                $modelM->delete();
                $data->addErrors($modelA->getErrors());
                return false;
            }
        }
        $model->datetime = $modelM->datetime;
        if ($model->sender_id == $modelM->sender_id) {
            $model->status_id = 1;
        }
        else {
            $model->status_id = 3;
        }
        if (!$model->save()) {
            $modelM->delete();
            $data->addErrors($model->getErrors());
        }
        return true;
    }
    public static function getUnreadCount() {
        $query = Tickets::find();
        $user = UsersSRL::findModel(Yii::$app->user->id);
        //$query->where(['sender_id' => $user->id, 'status_id' => 3]);
        if ($user->group->is_admin == 1) {
            $query->orWhere(['receiver_id' => null, 'status_id' => 1]);
        }
        else {
            $query->orWhere(['receiver_id' => $user->id, 'status_id' => 1]);
        }
        return $query->count();
    }
    public static function delete($id) {
        $model = self::findModel($id);
        if ($model == null) {
            return null;
        }
        $model->status_id = 4;
        return $model->save();
    }
}