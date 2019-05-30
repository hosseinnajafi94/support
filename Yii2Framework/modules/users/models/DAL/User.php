<?php
namespace app\modules\users\models\DAL;
use Yii;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;
use yii\base\NotSupportedException;
class User extends ActiveRecord implements IdentityInterface {
    public static function tableName() {
        return 'users';
    }
    public static function findIdentity($id) {
        $module = Yii::$app->getModule('users');
        return static::findOne([
            'id' => $id,
            'status_id' => $module->params['status.Active'],
            'can_login' => 1
        ]);
    }
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    public function getId() {
        return $this->getPrimaryKey();
    }
    public function getAuthKey() {
        return $this->auth_key;
    }
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }
}