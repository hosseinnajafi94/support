<?php
namespace app\modules\ticketing\models\SRL;
use Yii;
use app\modules\SRL;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use app\modules\ticketing\models\DAL\TicketsStatus;
use app\modules\ticketing\models\VML\TicketsStatusVML;
use app\modules\ticketing\models\VML\TicketsStatusSearchVML;
class TicketsStatusSRL implements SRL {
    /**
     * @return array [TicketsStatusSearchVML $searchModel, ActiveDataProvider $dataProvider]
     */
    public static function searchModel() {
        $searchModel = new TicketsStatusSearchVML();
        $query = TicketsStatus::find();
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
        $query->andFilterWhere(['like', 'title', $searchModel->title]);
        return [$searchModel, $dataProvider];
    }
    /**
     * @return TicketsStatusVML
     */
    public static function newViewModel() {
        $data = new TicketsStatusVML();
        return $data;
    }
    /**
     * @param TicketsStatusVML $data
     * @return void
     */
    public static function loadItems($data) {
    }
    /**
     * @param TicketsStatusVML $data
     * @return bool
     */
    public static function insert($data) {
        if (!$data->validate()) {
            return false;
        }
        $model = new TicketsStatus();
        $model->title = $data->title;
        if ($model->save()) {
            $data->id = $model->id;
            return true;
        }
        return false;
    }
    /**
     * @return TicketsStatus     */
    public static function findModel($id) {
        return TicketsStatus::findOne($id);
    }
    /**
     * @param int $id
     * @return TicketsStatusVML
     */
    public static function findViewModel($id) {
        $model = self::findModel($id);
        if ($model == null) {
            return null;
        }
        $data = new TicketsStatusVML();
        $data->id = $model->id;
        $data->title = $model->title;
        $data->setModel($model);
        return $data;
    }
    /**
     * @param TicketsStatusVML $data
     * @return bool
     */
    public static function update($data) {
        if (!$data->validate()) {
            return false;
        }
        $model = $data->getModel();
        $model->title = $data->title;
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
     * @return TicketsStatus[]
     */
    public static function getModels() {
        return TicketsStatus::find()->orderBy(['id' => SORT_ASC])->all();
    }
    /**
     * @return array
     */
    public static function getItems() {
        $models = self::getModels();
        return ArrayHelper::map($models, 'id', 'title');
    }
}