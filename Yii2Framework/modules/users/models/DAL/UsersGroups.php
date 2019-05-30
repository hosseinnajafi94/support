<?php
namespace app\modules\users\models\DAL;
use Yii;
/**
 * This is the model class for table "users_groups".
 * @author Hossein Najafi <hnajafi1994@gmail.com>
 *
 * @property int $id
 * @property string $title
 * @property int $is_admin
 * @property int $is_marketer
 * @property int $is_installer
 * @property int $is_sales_manager
 * @property int $is_customer
 * @property int $is_support
 *
 * @property Users[] $users
 */
class UsersGroups extends \yii\db\ActiveRecord {
    public static function tableName() {
        return 'users_groups';
    }
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
            'id'               => Yii::t('users', 'ID'),
            'title'            => Yii::t('users', 'Title'),
            'is_admin'         => Yii::t('users', 'Is Admin'),
            'is_marketer'      => Yii::t('users', 'Is Marketer'),
            'is_installer'     => Yii::t('users', 'Is Installer'),
            'is_sales_manager' => Yii::t('users', 'Is Sales Manager'),
            'is_customer'      => Yii::t('users', 'Is Customer'),
            'is_support'       => Yii::t('users', 'Is Support'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers() {
        return $this->hasMany(Users::className(), ['group_id' => 'id']);
    }
}