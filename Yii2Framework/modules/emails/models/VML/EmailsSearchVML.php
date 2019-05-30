<?php
namespace app\modules\emails\models\VML;
use Yii;
use yii\base\Model;
class EmailsSearchVML extends Model {
    public $to_email;
    public $to_name;
    public $subject;
    public $theme_id;
    public $themes = [];
    public function rules() {
        return [
                [['to_email', 'to_name', 'subject'], 'string', 'max' => 255],
                [['theme_id'], 'integer'],
        ];
    }
    public function attributeLabels() {
        return [
            'to_email' => Yii::t('emails', 'To Email'),
            'to_name' => Yii::t('emails', 'To Name'),
            'subject' => Yii::t('emails', 'Subject'),
            'theme_id' => Yii::t('emails', 'Theme ID'),
        ];
    }
}