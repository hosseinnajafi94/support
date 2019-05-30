<?php
namespace app\modules\sms\models\VML;
use Yii;
use yii\base\Model;
class SmsSettingsVML extends Model {
    public $id;
    public $address;
    public $username;
    public $password;
    public $line_number;
    private $_model;
    public function rules() {
        return [
                [['address', 'username', 'password', 'line_number'], 'required'],
                [['address', 'username', 'password', 'line_number'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels() {
        return [
            'address' => Yii::t('sms', 'Address'),
            'username' => Yii::t('sms', 'Username'),
            'password' => Yii::t('sms', 'Password'),
            'line_number' => Yii::t('sms', 'Line Number'),
        ];
    }
    public function setModel($model) {
        $this->_model = $model;
    }
    public function getModel() {
        return $this->_model;
    }
}