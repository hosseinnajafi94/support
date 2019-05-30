<?php
namespace app\modules\ticketing\models\DAL;
use Yii;
use app\modules\users\models\DAL\Users;
/**
 * This is the model class for table "tickets".
 * @author Hossein Najafi <hnajafi1994@gmail.com>
 *
 * @property int $id
 * @property string $title
 * @property int $type_id
 * @property int $sender_id
 * @property int $receiver_id
 * @property int $support_id
 * @property int $status_id
 * @property string $datetime
 *
 * @property TicketsTypes $type
 * @property Users $sender
 * @property Users $receiver
 * @property TicketsStatus $status
 * @property TicketsSupports $support
 * @property TicketsMessages[] $ticketsMessages
 */
class Tickets extends \yii\db\ActiveRecord {
    public static function tableName() {
        return 'tickets';
    }
    public function rules() {
        return [
                [['title', 'type_id', 'sender_id', 'status_id', 'datetime'], 'required'],
                [['type_id', 'sender_id', 'receiver_id', 'support_id', 'status_id'], 'integer'],
                [['datetime'], 'safe'],
                [['title'], 'string', 'max' => 255],
                [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TicketsTypes::className(), 'targetAttribute' => ['type_id' => 'id']],
                [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['sender_id' => 'id']],
                [['receiver_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['receiver_id' => 'id']],
                [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => TicketsStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
                [['support_id'], 'exist', 'skipOnError' => true, 'targetClass' => TicketsSupports::className(), 'targetAttribute' => ['support_id' => 'id']],
        ];
    }
    public function attributeLabels() {
        return [
            'id' => Yii::t('ticketing', 'ID'),
            'title' => Yii::t('ticketing', 'Title'),
            'type_id' => Yii::t('ticketing', 'Type ID'),
            'sender_id' => Yii::t('ticketing', 'Sender ID'),
            'receiver_id' => Yii::t('ticketing', 'Receiver ID'),
            'support_id' => Yii::t('ticketing', 'Support ID'),
            'status_id' => Yii::t('ticketing', 'Status ID'),
            'datetime' => Yii::t('ticketing', 'Datetime'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType() {
        return $this->hasOne(TicketsTypes::className(), ['id' => 'type_id']);
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
    public function getReceiver() {
        return $this->hasOne(Users::className(), ['id' => 'receiver_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus() {
        return $this->hasOne(TicketsStatus::className(), ['id' => 'status_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupport() {
        return $this->hasOne(TicketsSupports::className(), ['id' => 'support_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicketsMessages() {
        return $this->hasMany(TicketsMessages::className(), ['ticket_id' => 'id']);
    }
}