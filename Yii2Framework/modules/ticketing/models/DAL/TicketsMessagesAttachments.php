<?php
namespace app\modules\ticketing\models\DAL;
use Yii;
/**
 * This is the model class for table "tickets_messages_attachments".
 * @author Hossein Najafi <hnajafi1994@gmail.com>
 *
 * @property int $id
 * @property int $message_id
 * @property string $file
 *
 * @property TicketsMessages $message
 */
class TicketsMessagesAttachments extends \yii\db\ActiveRecord {
    public static function tableName() {
        return 'tickets_messages_attachments';
    }
    public function rules() {
        return [
                [['message_id', 'file'], 'required'],
                [['message_id'], 'integer'],
                [['file'], 'string', 'max' => 255],
                [['message_id'], 'exist', 'skipOnError' => true, 'targetClass' => TicketsMessages::className(), 'targetAttribute' => ['message_id' => 'id']],
        ];
    }
    public function attributeLabels() {
        return [
            'id' => Yii::t('ticketing', 'ID'),
            'message_id' => Yii::t('ticketing', 'Message ID'),
            'file' => Yii::t('ticketing', 'File'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessage() {
        return $this->hasOne(TicketsMessages::className(), ['id' => 'message_id']);
    }
}