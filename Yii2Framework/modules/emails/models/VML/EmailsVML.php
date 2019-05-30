<?php
namespace app\modules\emails\models\VML;
use Yii;
use yii\base\Model;
class EmailsVML extends Model {
    public $id;
    public $receiver_email;
    public $receiver_name;
    public $subject;
    public $message;
    public function rules() {
        return [
            [['receiver_email', 'receiver_name', 'subject', 'message'], 'required'],
            [['receiver_name', 'subject'], 'string', 'max' => 255],
            [['receiver_email'], 'email'],
            [['message'], 'string']
        ];
    }
    public function attributeLabels() {
        return [
            'receiver_email' => Yii::t('emails', 'Receiver Email'),
            'receiver_name'  => Yii::t('emails', 'Receiver Name'),
            'subject'        => Yii::t('emails', 'Subject'),
            'message'        => Yii::t('emails', 'Message')
        ];
    }
}