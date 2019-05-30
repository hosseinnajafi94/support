<?php
namespace app\modules\users\models\VML;
use Yii;
use yii\base\Model;
class UsersGroupsVML extends Model {
    public $id;
    public $title;
    public $is_admin;
    public $is_marketer;
    public $is_installer;
    public $is_sales_manager;
    public $is_customer;
    public $is_support;
    private $_model;
    public function rules() {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['is_admin', 'is_marketer', 'is_installer', 'is_sales_manager', 'is_customer', 'is_support'], 'integer'],
            [['is_admin', 'is_marketer', 'is_installer', 'is_sales_manager', 'is_customer', 'is_support'], 'in', 'range' => [0, 1]],
            [['is_admin', 'is_marketer', 'is_installer', 'is_sales_manager', 'is_customer', 'is_support'], 'default', 'value' => 0],
        ];
    }
    public function attributeLabels() {
        return [
            'title'            => Yii::t('users', 'Title'),
            'is_admin'         => Yii::t('users', 'Is Admin'),
            'is_marketer'      => Yii::t('users', 'Is Marketer'),
            'is_installer'     => Yii::t('users', 'Is Installer'),
            'is_sales_manager' => Yii::t('users', 'Is Sales Manager'),
            'is_customer'      => Yii::t('users', 'Is Customer'),
            'is_support'       => Yii::t('users', 'Is Support'),
        ];
    }
    public function setModel($model) {
        $this->_model = $model;
    }
    public function getModel() {
        return $this->_model;
    }
}