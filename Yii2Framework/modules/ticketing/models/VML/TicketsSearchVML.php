<?php
namespace app\modules\ticketing\models\VML;
use Yii;
use yii\base\Model;
class TicketsSearchVML extends Model {
    public $title;
    public $type_id;
    public $sender_id;
    public $receiver_id;
    public $support_id;
    public $status_id;
    public $datetime;
    public $types = [];
    public $senders = [];
    public $receivers = [];
    public $supports = [];
    public $statuses = [];
    public function rules() {
        return [
                [['title'], 'string', 'max' => 255],
                [['type_id', 'sender_id', 'receiver_id', 'support_id', 'status_id'], 'integer'],
                [['datetime'], 'safe'],
        ];
    }
    public function attributeLabels() {
        return [
            'title' => Yii::t('ticketing', 'Title'),
            'type_id' => Yii::t('ticketing', 'Type ID'),
            'sender_id' => Yii::t('ticketing', 'Sender ID'),
            'receiver_id' => Yii::t('ticketing', 'Receiver ID'),
            'support_id' => Yii::t('ticketing', 'Support ID'),
            'status_id' => Yii::t('ticketing', 'Status ID'),
            'datetime' => Yii::t('ticketing', 'Datetime'),
        ];
    }
}