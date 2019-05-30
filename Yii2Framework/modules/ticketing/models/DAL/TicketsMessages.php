<?php
namespace app\modules\ticketing\models\DAL;
use Yii;
use app\modules\users\models\DAL\Users;
/**
 * This is the model class for table "tickets_messages".
 * @author Hossein Najafi <hnajafi1994@gmail.com>
 *
 * @property int $id
 * @property int $ticket_id
 * @property int $sender_id
 * @property string $message
 * @property string $datetime
 *
 * @property Tickets $ticket
 * @property Users $sender
 * @property TicketsMessagesAttachments[] $ticketsMessagesAttachments
 */
class TicketsMessages extends \yii\db\ActiveRecord {
    public static function tableName() {
        return 'tickets_messages';
    }
    public function rules() {
        return [
                [['ticket_id', 'sender_id', 'message', 'datetime'], 'required'],
                [['ticket_id', 'sender_id'], 'integer'],
                [['message'], 'string'],
                [['datetime'], 'safe'],
                [['ticket_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tickets::className(), 'targetAttribute' => ['ticket_id' => 'id']],
                [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['sender_id' => 'id']],
        ];
    }
    public function attributeLabels() {
        return [
            'id' => Yii::t('ticketing', 'ID'),
            'ticket_id' => Yii::t('ticketing', 'Ticket ID'),
            'sender_id' => Yii::t('ticketing', 'Sender ID'),
            'message' => Yii::t('ticketing', 'Message'),
            'datetime' => Yii::t('ticketing', 'Datetime'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicket() {
        return $this->hasOne(Tickets::className(), ['id' => 'ticket_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender() {
        return $this->hasOne(Users::className(), ['id' => 'sender_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicketsMessagesAttachments() {
        return $this->hasMany(TicketsMessagesAttachments::className(), ['message_id' => 'id']);
    }
}