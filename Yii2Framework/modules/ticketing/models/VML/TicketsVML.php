<?php
namespace app\modules\ticketing\models\VML;
use Yii;
use yii\base\Model;
class TicketsVML extends Model {
    public $id;
    public $title;
    public $receiver_id;
    public $support_id;
    public $message;
    public $file;
    public $types = [];
    public $receivers = [];
    public $supports = [];
    public $user;
    private $_model;
    public function rules() {
        return [
                [['title', 'support_id', 'message'], 'required'],
                [['receiver_id'], 'required', 'when' => function ($model) {
                    return $model->user->group->is_admin == 1;
                }, 'whenClient' => 'function (attribute) {
                    return ' . ($this->user->group->is_admin == 1 ? 'false' : 'false') . ';
                }'],
                [['receiver_id', 'support_id'], 'integer'],
                [['title'], 'string', 'max' => 255],
                [['message'], 'string'],
                [['file'], 'file', 'skipOnEmpty' => true, 'maxSize' => 1024 * 1024 * 10, 'extensions' => 'zip'],
        ];
    }
    public function attributeLabels() {
        return [
            'title' => Yii::t('ticketing', 'Title'),
            'receiver_id' => Yii::t('ticketing', 'Receiver ID'),
            'support_id' => Yii::t('ticketing', 'Support ID'),
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