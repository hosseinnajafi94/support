<?php
namespace app\modules\ticketing\models\SRL;
use Yii;
use app\modules\SRL;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use app\modules\ticketing\models\DAL\TicketsMessages;
use app\modules\ticketing\models\VML\TicketsMessagesVML;
use app\modules\ticketing\models\VML\TicketsMessagesSearchVML;
use app\modules\users\models\SRL\UsersSRL;
class TicketsMessagesSRL implements SRL {
    /**
     * @return array [TicketsMessagesSearchVML $searchModel, ActiveDataProvider $dataProvider]
     */
    public static function searchModel() {
        $searchModel = new TicketsMessagesSearchVML();
        $query = TicketsMessages::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => ['defaultPageSize' => 10]
        ]);
        $searchModel->load(Yii::$app->request->queryParams);
        self::loadItems($searchModel);
        if (!$searchModel->validate()) {
            $query->where('0=1');
            return [$searchModel, $dataProvider];
        }
        $query->andFilterWhere(['ticket_id' => $searchModel->ticket_id]);
        $query->andFilterWhere(['sender_id' => $searchModel->sender_id]);
        $query->andFilterWhere(['datetime' => $searchModel->datetime]);
        $query->andFilterWhere(['like', 'message', $searchModel->message]);
        return [$searchModel, $dataProvider];
    }
    /**
     * @return TicketsMessagesVML
     */
    public static function newViewModel() {
        $data = new TicketsMessagesVML();
        return $data;
    }
    /**
     * @param TicketsMessagesVML $data
     * @return void
     */
    public static function loadItems($data) {
        $data->tickets = TicketsSRL::getItems();
        $data->senders = UsersSRL::getItems();
    }
    /**
     * @param TicketsMessagesVML $data
     * @return bool
     */
    public static function insert($data) {
        if (!$data->validate()) {
            return false;
        }
        $model = new TicketsMessages();
        $model->ticket_id = $data->ticket_id;
        $model->sender_id = $data->sender_id;
        $model->message = $data->message;
        $model->datetime = $data->datetime;
        if ($model->save()) {
            $data->id = $model->id;
            return true;
        }
        return false;
    }
    /**
     * @return TicketsMessages     */
    public static function findModel($id) {
        return TicketsMessages::findOne($id);
    }
    /**
     * @param int $id
     * @return TicketsMessagesVML
     */
    public static function findViewModel($id) {
        $model = self::findModel($id);
        if ($model == null) {
            return null;
        }
        $data = new TicketsMessagesVML();
        $data->id = $model->id;
        $data->ticket_id = $model->ticket_id;
        $data->sender_id = $model->sender_id;
        $data->message = $model->message;
        $data->datetime = $model->datetime;
        $data->setModel($model);
        return $data;
    }
    /**
     * @param TicketsMessagesVML $data
     * @return bool
     */
    public static function update($data) {
        if (!$data->validate()) {
            return false;
        }
        $model = $data->getModel();
        $model->ticket_id = $data->ticket_id;
        $model->sender_id = $data->sender_id;
        $model->message = $data->message;
        $model->datetime = $data->datetime;
        return $model->save();
    }
    /**
     * @param int $id
     * @return bool
     */
    public static function delete($id) {
        $model = self::findModel($id);
        if ($model == null) {
            return false;
        }
        return $model->delete() ? true : false;
    }
    /**
     * @return TicketsMessages[]
     */
    public static function getModels() {
        return TicketsMessages::find()->orderBy(['id' => SORT_ASC])->all();
    }
    /**
     * @return array
     */
    public static function getItems() {
        $models = self::getModels();
        return ArrayHelper::map($models, 'id', 'id');
    }
}