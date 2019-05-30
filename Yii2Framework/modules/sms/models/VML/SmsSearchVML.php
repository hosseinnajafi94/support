<?php
namespace app\modules\sms\models\VML;
use Yii;
use yii\base\Model;
class SmsSearchVML extends Model {
    public $to_number;
    public $message;
    public $datetime;
    public function rules() {
        return [
                [['to_number', 'message'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels() {
        return [
            'to_number' => Yii::t('sms', 'To Number'),
            'message' => Yii::t('sms', 'Message'),
        ];
    }
}