<?php
namespace app\modules\ticketing\models\VML;
use Yii;
use yii\base\Model;
class AnswerVML extends Model {
    public $message;
    public $file;
    private $_model;
    public function rules() {
        return [
                [['message'], 'required'],
                [['message'], 'string'],
                [['file'], 'file', 'skipOnEmpty' => true, 'maxSize' => 1024 * 1024 * 10, 'extensions' => 'zip'],
        ];
    }
    public function attributeLabels() {
        return [
            'message' => Yii::t('ticketing', 'Message'),
            'file' => Yii::t('ticketing', 'File'),
        ];
    }
    public function attributeHints() {
        return [
            'file' => 'حداکثر حجم مجاز 10MB, پسوند مجاز zip',
        ];
    }
    public function setModel($model) {
        $this->_model = $model;
    }
    public function getModel() {
        return $this->_model;
    }
}