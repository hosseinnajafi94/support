<?php
namespace app\modules\coding\models\SRL;
use Yii;
use app\modules\SRL;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use app\modules\coding\models\DAL\Payments;
use app\modules\coding\models\VML\PaymentsVML;
use app\modules\coding\models\VML\PaymentsSearchVML;
class PaymentsSRL implements SRL {
    /**
     * @return array [PaymentsSearchVML $searchModel, ActiveDataProvider $dataProvider]
     */
    public static function searchModel() {
        $searchModel = new PaymentsSearchVML();
        $query = Payments::find();
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
        $query->andFilterWhere(['paid' => $searchModel->paid]);
        $query->andFilterWhere(['id_p1' => $searchModel->id_p1]);
        $query->andFilterWhere(['id_user1' => $searchModel->id_user1]);
        $query->andFilterWhere(['valint1' => $searchModel->valint1]);
        $query->andFilterWhere(['datetime' => $searchModel->datetime]);
        $query->andFilterWhere(['gateway' => $searchModel->gateway]);
        $query->andFilterWhere(['like', 'mellat_ref_id', $searchModel->mellat_ref_id]);
        $query->andFilterWhere(['like', 'mellat_res_code', $searchModel->mellat_res_code]);
        $query->andFilterWhere(['like', 'mellat_sale_order_id', $searchModel->mellat_sale_order_id]);
        $query->andFilterWhere(['like', 'mellat_reference_id', $searchModel->mellat_reference_id]);
        $query->andFilterWhere(['like', 'irankish_token', $searchModel->irankish_token]);
        $query->andFilterWhere(['like', 'irankish_result_code', $searchModel->irankish_result_code]);
        $query->andFilterWhere(['like', 'irankish_reference_id', $searchModel->irankish_reference_id]);
        $query->andFilterWhere(['like', 'zarinpal_authority', $searchModel->zarinpal_authority]);
        $query->andFilterWhere(['like', 'zarinpal_ref_id', $searchModel->zarinpal_ref_id]);
        return [$searchModel, $dataProvider];
    }
    /**
     * @return PaymentsVML
     */
    public static function newViewModel() {
        $data = new PaymentsVML();
        return $data;
    }
    /**
     * @param PaymentsVML $data
     * @return void
     */
    public static function loadItems($data) {
    }
    /**
     * @param PaymentsVML $data
     * @return bool
     */
    public static function insert($data) {
        if (!$data->validate()) {
            return false;
        }
        $model = new Payments();
        $model->paid = $data->paid;
        $model->id_p1 = $data->id_p1;
        $model->id_user1 = $data->id_user1;
        $model->valint1 = $data->valint1;
        $model->datetime = $data->datetime;
        $model->gateway = $data->gateway;
        $model->mellat_ref_id = $data->mellat_ref_id;
        $model->mellat_res_code = $data->mellat_res_code;
        $model->mellat_sale_order_id = $data->mellat_sale_order_id;
        $model->mellat_reference_id = $data->mellat_reference_id;
        $model->irankish_token = $data->irankish_token;
        $model->irankish_result_code = $data->irankish_result_code;
        $model->irankish_reference_id = $data->irankish_reference_id;
        $model->zarinpal_authority = $data->zarinpal_authority;
        $model->zarinpal_ref_id = $data->zarinpal_ref_id;
        if ($model->save()) {
            $data->id = $model->id;
            return true;
        }
        return false;
    }
    /**
     * @return Payments     */
    public static function findModel($id) {
        return Payments::findOne($id);
    }
    /**
     * @param int $id
     * @return PaymentsVML
     */
    public static function findViewModel($id) {
        $model = self::findModel($id);
        if ($model == null) {
            return null;
        }
        $data = new PaymentsVML();
        $data->id = $model->id;
        $data->paid = $model->paid;
        $data->id_p1 = $model->id_p1;
        $data->id_user1 = $model->id_user1;
        $data->valint1 = $model->valint1;
        $data->datetime = $model->datetime;
        $data->gateway = $model->gateway;
        $data->mellat_ref_id = $model->mellat_ref_id;
        $data->mellat_res_code = $model->mellat_res_code;
        $data->mellat_sale_order_id = $model->mellat_sale_order_id;
        $data->mellat_reference_id = $model->mellat_reference_id;
        $data->irankish_token = $model->irankish_token;
        $data->irankish_result_code = $model->irankish_result_code;
        $data->irankish_reference_id = $model->irankish_reference_id;
        $data->zarinpal_authority = $model->zarinpal_authority;
        $data->zarinpal_ref_id = $model->zarinpal_ref_id;
        $data->setModel($model);
        return $data;
    }
    /**
     * @param PaymentsVML $data
     * @return bool
     */
    public static function update($data) {
        if (!$data->validate()) {
            return false;
        }
        $model = $data->getModel();
        $model->paid = $data->paid;
        $model->id_p1 = $data->id_p1;
        $model->id_user1 = $data->id_user1;
        $model->valint1 = $data->valint1;
        $model->datetime = $data->datetime;
        $model->gateway = $data->gateway;
        $model->mellat_ref_id = $data->mellat_ref_id;
        $model->mellat_res_code = $data->mellat_res_code;
        $model->mellat_sale_order_id = $data->mellat_sale_order_id;
        $model->mellat_reference_id = $data->mellat_reference_id;
        $model->irankish_token = $data->irankish_token;
        $model->irankish_result_code = $data->irankish_result_code;
        $model->irankish_reference_id = $data->irankish_reference_id;
        $model->zarinpal_authority = $data->zarinpal_authority;
        $model->zarinpal_ref_id = $data->zarinpal_ref_id;
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
     * @return Payments[]
     */
    public static function getModels() {
        return Payments::find()->orderBy(['id' => SORT_ASC])->all();
    }
    /**
     * @return array
     */
    public static function getItems() {
        $models = self::getModels();
        return ArrayHelper::map($models, 'id', 'id');
    }
}