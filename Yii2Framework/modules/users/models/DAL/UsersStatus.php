<?php
namespace app\modules\users\models\DAL;
use Yii;
/**
 * This is the model class for table "users_status".
 * @author Hossein Najafi <hnajafi1994@gmail.com>
 *
 * @property int $id
 * @property string $title
 *
 * @property Users[] $users
 */
class UsersStatus extends \yii\db\ActiveRecord {
    public static function tableName() {
        return 'users_status';
    }
    public function rules() {
        return [
                [['title'], 'required'],
                [['title'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels() {
        return [
            'id' => Yii::t('users', 'ID'),
            'title' => Yii::t('users', 'Title'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers() {
        return $this->hasMany(Users::className(), ['status_id' => 'id']);
    }
}