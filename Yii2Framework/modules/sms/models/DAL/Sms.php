<?php
namespace app\modules\sms\models\DAL;
use Yii;
/**
 * This is the model class for table "sms".
 * @author Hossein Najafi <hnajafi1994@gmail.com>
 *
 * @property int $id
 * @property string $from_number
 * @property string $to_number
 * @property string $message
 * @property string $datetime
 */
class Sms extends \yii\db\ActiveRecord {
    public static function tableName() {
        return 'sms';
    }
    public function rules() {
        return [
                [['from_number', 'to_number', 'message', 'datetime'], 'required'],
                [['message'], 'string'],
                [['datetime'], 'safe'],
                [['from_number'], 'string', 'max' => 255],
                [['to_number'], 'string', 'max' => 11],
        ];
    }
    public function attributeLabels() {
        return [
            'id' => Yii::t('sms', 'ID'),
            'from_number' => Yii::t('sms', 'From Number'),
            'to_number' => Yii::t('sms', 'To Number'),
            'message' => Yii::t('sms', 'Message'),
            'datetime' => Yii::t('sms', 'Datetime'),
        ];
    }
}