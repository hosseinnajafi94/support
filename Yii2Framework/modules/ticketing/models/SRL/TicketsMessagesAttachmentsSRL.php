<?php
namespace app\modules\ticketing\models\SRL;
use Yii;
use app\modules\SRL;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use app\modules\ticketing\models\DAL\TicketsMessagesAttachments;
use app\modules\ticketing\models\VML\TicketsMessagesAttachmentsVML;
use app\modules\ticketing\models\VML\TicketsMessagesAttachmentsSearchVML;
class TicketsMessagesAttachmentsSRL implements SRL {
    /**
     * @return array [TicketsMessagesAttachmentsSearchVML $searchModel, ActiveDataProvider $dataProvider]
     */
    public static function searchModel() {
        $searchModel = new TicketsMessagesAttachmentsSearchVML();
        $query = TicketsMessagesAttachments::find();
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
        $query->andFilterWhere(['message_id' => $searchModel->message_id]);
        $query->andFilterWhere(['like', 'file', $searchModel->file]);
        return [$searchModel, $dataProvider];
    }
    /**
     * @return TicketsMessagesAttachmentsVML
     */
    public static function newViewModel() {
        $data = new TicketsMessagesAttachmentsVML();
        return $data;
    }
    /**
     * @param TicketsMessagesAttachmentsVML $data
     * @return void
     */
    public static function loadItems($data) {
        $data->messages = TicketsMessagesSRL::getItems();
    }
    /**
     * @param TicketsMessagesAttachmentsVML $data
     * @return bool
     */
    public static function insert($data) {
        if (!$data->validate()) {
            return false;
        }
        $model = new TicketsMessagesAttachments();
        $model->message_id = $data->message_id;
        $model->file = $data->file;
        if ($model->save()) {
            $data->id = $model->id;
            return true;
        }
        return false;
    }
    /**
     * @return TicketsMessagesAttachments     */
    public static function findModel($id) {
        return TicketsMessagesAttachments::findOne($id);
    }
    /**
     * @param int $id
     * @return TicketsMessagesAttachmentsVML
     */
    public static function findViewModel($id) {
        $model = self::findModel($id);
        if ($model == null) {
            return null;
        }
        $data = new TicketsMessagesAttachmentsVML();
        $data->id = $model->id;
        $data->message_id = $model->message_id;
        $data->file = $model->file;
        $data->setModel($model);
        return $data;
    }
    /**
     * @param TicketsMessagesAttachmentsVML $data
     * @return bool
     */
    public static function update($data) {
        if (!$data->validate()) {
            return false;
        }
        $model = $data->getModel();
        $model->message_id = $data->message_id;
        $model->file = $data->file;
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
     * @return TicketsMessagesAttachments[]
     */
    public static function getModels() {
        return TicketsMessagesAttachments::find()->orderBy(['id' => SORT_ASC])->all();
    }
    /**
     * @return array
     */
    public static function getItems() {
        $models = self::getModels();
        return ArrayHelper::map($models, 'id', 'id');
    }
}