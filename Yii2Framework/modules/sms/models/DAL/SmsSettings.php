<?php
namespace app\modules\sms\models\DAL;
use Yii;
/**
 * This is the model class for table "sms_settings".
 * @author Hossein Najafi <hnajafi1994@gmail.com>
 *
 * @property int $id
 * @property string $address
 * @property string $username
 * @property string $password
 * @property string $line_number
 */
class SmsSettings extends \yii\db\ActiveRecord {
    public static function tableName() {
        return 'sms_settings';
    }
    public function rules() {
        return [
                [['address', 'username', 'password', 'line_number'], 'required'],
                [['address', 'username', 'password', 'line_number'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels() {
        return [
            'id' => Yii::t('sms', 'ID'),
            'address' => Yii::t('sms', 'Address'),
            'username' => Yii::t('sms', 'Username'),
            'password' => Yii::t('sms', 'Password'),
            'line_number' => Yii::t('sms', 'Line Number'),
        ];
    }
}