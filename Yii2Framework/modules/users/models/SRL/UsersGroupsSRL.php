<?php
namespace app\modules\users\models\SRL;
use app\modules\SRL;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use app\modules\users\models\DAL\UsersGroups;
use app\modules\users\models\VML\UsersGroupsVML;
class UsersGroupsSRL implements SRL {
    /**
     * @return array [UsersGroupsSearchVML $searchModel, ActiveDataProvider $dataProvider]
     */
    public static function searchModel() {
        $query        = UsersGroups::find()->orderBy(['id' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'sort'       => false,
            'pagination' => ['defaultPageSize' => 10]
        ]);
        return $dataProvider;
    }
    /**
     * @return UsersGroupsVML
     */
    public static function newViewModel() {
        $data = new UsersGroupsVML();
        return $data;
    }
    /**
     * @param UsersGroupsVML $data
     * @return void
     */
    public static function loadItems($data) {
        
    }
    /**
     * @param UsersGroupsVML $data
     * @return bool
     */
    public static function insert($data) {
        if (!$data->validate()) {
            return false;
        }
        $model                   = new UsersGroups();
        $model->title            = $data->title;
        $model->is_admin         = $data->is_admin;
        $model->is_marketer      = $data->is_marketer;
        $model->is_installer     = $data->is_installer;
        $model->is_sales_manager = $data->is_sales_manager;
        $model->is_customer      = $data->is_customer;
        $model->is_support       = $data->is_support;
        if ($model->save()) {
            $data->id = $model->id;
            return true;
        }
        return false;
    }
    /**
     * @return UsersGroups
     */
    public static function findModel($id) {
        return UsersGroups::findOne($id);
    }
    /**
     * @param int $id
     * @return UsersGroupsVML
     */
    public static function findViewModel($id) {
        $model = self::findModel($id);
        if ($model == null) {
            return null;
        }
        $data                   = new UsersGroupsVML();
        $data->id               = $model->id;
        $data->title            = $model->title;
        $data->is_admin         = $model->is_admin;
        $data->is_marketer      = $model->is_marketer;
        $data->is_installer     = $model->is_installer;
        $data->is_sales_manager = $model->is_sales_manager;
        $data->is_customer      = $model->is_customer;
        $data->is_support       = $model->is_support;
        $data->setModel($model);
        return $data;
    }
    /**
     * @param UsersGroupsVML $data
     * @return bool
     */
    public static function update($data) {
        if (!$data->validate()) {
            return false;
        }
        $model                   = $data->getModel();
        $model->title            = $data->title;
        $model->is_admin         = $data->is_admin;
        $model->is_marketer      = $data->is_marketer;
        $model->is_installer     = $data->is_installer;
        $model->is_sales_manager = $data->is_sales_manager;
        $model->is_customer      = $data->is_customer;
        $model->is_support       = $data->is_support;
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
     * @return UsersGroups[]
     */
    public static function getModels() {
        return UsersGroups::find()->orderBy(['id' => SORT_ASC])->all();
    }
    /**
     * @return array
     */
    public static function getItems() {
        $models = self::getModels();
        return ArrayHelper::map($models, 'id', 'title');
    }
}