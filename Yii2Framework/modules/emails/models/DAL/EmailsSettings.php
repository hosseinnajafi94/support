<?php
namespace app\modules\emails\models\DAL;
use Yii;
/**
 * This is the model class for table "emails_settings".
 * @author Hossein Najafi <hnajafi1994@gmail.com>
 *
 * @property int $id
 * @property string $server
 * @property string $port
 * @property string $username
 * @property string $password
 */
class EmailsSettings extends \yii\db\ActiveRecord {
    public static function tableName() {
        return 'emails_settings';
    }
    public function rules() {
        return [
                [['server', 'port', 'username', 'password'], 'required'],
                [['server', 'port', 'username', 'password'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels() {
        return [
            'id' => Yii::t('emails', 'ID'),
            'server' => Yii::t('emails', 'Server'),
            'port' => Yii::t('emails', 'Port'),
            'username' => Yii::t('emails', 'Username'),
            'password' => Yii::t('emails', 'Password'),
        ];
    }
}