<?php
namespace app\modules\ticketing\models\VML;
use Yii;
use yii\base\Model;
class TicketsSupportsVML extends Model {
    public $id;
    public $title;
    private $_model;
    public function rules() {
        return [
                [['title'], 'required'],
                [['title'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels() {
        return [
            'title' => Yii::t('ticketing', 'Title'),
        ];
    }
    public function setModel($model) {
        $this->_model = $model;
    }
    public function getModel() {
        return $this->_model;
    }
}