<?php
namespace app\modules\sms\models\VML;
use Yii;
use yii\base\Model;
class SmsVML extends Model {
    public $id;
    public $receiver;
    public $message;
    private $_model;
    public function rules() {
        return [
                [['receiver'], 'required'],
                [['receiver'], 'string', 'min' => 11, 'max' => 11],
                [['receiver'], 'match', 'pattern' => "/^09[0-9]{9}$/"],
                [['message'], 'required'],
                [['message'], 'string'],
        ];
    }
    public function attributeLabels() {
        return [
            'receiver' => Yii::t('sms', 'Receiver'),
            'message' => Yii::t('sms', 'Message'),
        ];
    }
    public function setModel($model) {
        $this->_model = $model;
    }
    public function getModel() {
        return $this->_model;
    }
}