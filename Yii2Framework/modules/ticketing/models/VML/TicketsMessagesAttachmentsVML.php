<?php
namespace app\modules\ticketing\models\VML;
use Yii;
use yii\base\Model;
class TicketsMessagesAttachmentsVML extends Model {
    public $id;
    public $message_id;
    public $file;
    public $messages = [];
    private $_model;
    public function rules() {
        return [
                [['message_id', 'file'], 'required'],
                [['message_id'], 'integer'],
                [['file'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels() {
        return [
            'message_id' => Yii::t('ticketing', 'Message ID'),
            'file' => Yii::t('ticketing', 'File'),
        ];
    }
    public function setModel($model) {
        $this->_model = $model;
    }
    public function getModel() {
        return $this->_model;
    }
}