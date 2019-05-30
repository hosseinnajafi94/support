<?php
namespace app\modules\emails\models\VML;
use Yii;
use yii\base\Model;
class EmailsSettingsVML extends Model {
    public $id;
    public $server;
    public $port;
    public $username;
    public $password;
    private $_model;
    public function rules() {
        return [
                [['server', 'port', 'username', 'password'], 'required'],
                [['server', 'port', 'username', 'password'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels() {
        return [
            'server' => Yii::t('emails', 'Server'),
            'port' => Yii::t('emails', 'Port'),
            'username' => Yii::t('emails', 'Username'),
            'password' => Yii::t('emails', 'Password'),
        ];
    }
    public function setModel($model) {
        $this->_model = $model;
    }
    public function getModel() {
        return $this->_model;
    }
}