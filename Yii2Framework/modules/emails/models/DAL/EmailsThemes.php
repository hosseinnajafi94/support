<?php
namespace app\modules\emails\models\DAL;
use Yii;
/**
 * This is the model class for table "emails_themes".
 * @author Hossein Najafi <hnajafi1994@gmail.com>
 *
 * @property int $id
 * @property string $title
 * @property string $theme
 *
 * @property Emails[] $emails
 */
class EmailsThemes extends \yii\db\ActiveRecord {
    public static function tableName() {
        return 'emails_themes';
    }
    public function rules() {
        return [
                [['title', 'theme'], 'required'],
                [['theme'], 'string'],
                [['title'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels() {
        return [
            'id' => Yii::t('emails', 'ID'),
            'title' => Yii::t('emails', 'Title'),
            'theme' => Yii::t('emails', 'Theme'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmails() {
        return $this->hasMany(Emails::className(), ['theme_id' => 'id']);
    }
}