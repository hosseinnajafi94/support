<?php
namespace app\modules\ticketing\models\VML;
use Yii;
use yii\base\Model;
class TicketsMessagesVML extends Model {
    public $id;
    public $ticket_id;
    public $sender_id;
    public $message;
    public $datetime;
    public $tickets = [];
    public $senders = [];
    private $_model;
    public function rules() {
        return [
                [['ticket_id', 'sender_id', 'message', 'datetime'], 'required'],
                [['ticket_id', 'sender_id'], 'integer'],
                [['message'], 'string'],
                [['datetime'], 'safe'],
        ];
    }
    public function attributeLabels() {
        return [
            'ticket_id' => Yii::t('ticketing', 'Ticket ID'),
            'sender_id' => Yii::t('ticketing', 'Sender ID'),
            'message' => Yii::t('ticketing', 'Message'),
            'datetime' => Yii::t('ticketing', 'Datetime'),
        ];
    }
    public function setModel($model) {
        $this->_model = $model;
    }
    public function getModel() {
        return $this->_model;
    }
}