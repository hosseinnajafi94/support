<?php
namespace app\modules\ticketing\models\SRL;
use Yii;
use app\modules\SRL;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use app\modules\ticketing\models\DAL\TicketsTypes;
use app\modules\ticketing\models\VML\TicketsTypesVML;
use app\modules\ticketing\models\VML\TicketsTypesSearchVML;
class TicketsTypesSRL implements SRL {
    /**
     * @return array [TicketsTypesSearchVML $searchModel, ActiveDataProvider $dataProvider]
     */
    public static function searchModel() {
        $searchModel = new TicketsTypesSearchVML();
        $query = TicketsTypes::find();
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
     * @return TicketsTypesVML
     */
    public static function newViewModel() {
        $data = new TicketsTypesVML();
        return $data;
    }
    /**
     * @param TicketsTypesVML $data
     * @return void
     */
    public static function loadItems($data) {
    }
    /**
     * @param TicketsTypesVML $data
     * @return bool
     */
    public static function insert($data) {
        if (!$data->validate()) {
            return false;
        }
        $model = new TicketsTypes();
        $model->title = $data->title;
        if ($model->save()) {
            $data->id = $model->id;
            return true;
        }
        return false;
    }
    /**
     * @return TicketsTypes     */
    public static function findModel($id) {
        return TicketsTypes::findOne($id);
    }
    /**
     * @param int $id
     * @return TicketsTypesVML
     */
    public static function findViewModel($id) {
        $model = self::findModel($id);
        if ($model == null) {
            return null;
        }
        $data = new TicketsTypesVML();
        $data->id = $model->id;
        $data->title = $model->title;
        $data->setModel($model);
        return $data;
    }
    /**
     * @param TicketsTypesVML $data
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
     * @return TicketsTypes[]
     */
    public static function getModels() {
        return TicketsTypes::find()->orderBy(['id' => SORT_ASC])->all();
    }
    /**
     * @return array
     */
    public static function getItems() {
        $models = self::getModels();
        return ArrayHelper::map($models, 'id', 'title');
    }
}