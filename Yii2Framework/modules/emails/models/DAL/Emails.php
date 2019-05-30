<?php
namespace app\modules\emails\models\DAL;
use Yii;
/**
 * This is the model class for table "emails".
 * @author Hossein Najafi <hnajafi1994@gmail.com>
 *
 * @property int $id
 * @property string $from_email
 * @property string $from_name
 * @property string $to_email
 * @property string $to_name
 * @property string $datetime
 * @property string $subject
 * @property string $message
 * @property int $theme_id
 *
 * @property EmailsThemes $theme
 */
class Emails extends \yii\db\ActiveRecord {
    public static function tableName() {
        return 'emails';
    }
    public function rules() {
        return [
                [['from_email', 'from_name', 'to_email', 'to_name', 'datetime', 'subject', 'message', 'theme_id'], 'required'],
                [['datetime'], 'safe'],
                [['message'], 'string'],
                [['theme_id'], 'integer'],
                [['from_email', 'from_name', 'to_email', 'to_name', 'subject'], 'string', 'max' => 255],
                [['theme_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmailsThemes::className(), 'targetAttribute' => ['theme_id' => 'id']],
        ];
    }
    public function attributeLabels() {
        return [
            'id' => Yii::t('emails', 'ID'),
            'from_email' => Yii::t('emails', 'From Email'),
            'from_name' => Yii::t('emails', 'From Name'),
            'to_email' => Yii::t('emails', 'To Email'),
            'to_name' => Yii::t('emails', 'To Name'),
            'datetime' => Yii::t('emails', 'Datetime'),
            'subject' => Yii::t('emails', 'Subject'),
            'message' => Yii::t('emails', 'Message'),
            'theme_id' => Yii::t('emails', 'Theme ID'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTheme() {
        return $this->hasOne(EmailsThemes::className(), ['id' => 'theme_id']);
    }
}