<?php
namespace app\modules\coding\models\VML;
use Yii;
use yii\base\Model;
class HesabhaVML2 extends Model {
    public $id_p2;
    public $mab;
    public $ps   = [];
    private $_model;
    public function rules() {
        return [
                [['id_p2', 'mab'], 'required'],
                [['id_p2', 'mab'], 'integer'],
        ];
    }
    public function attributeLabels() {
        return [
            'id_p2'    => Yii::t('coding', 'Hesab Bedehkari'),
            'mab'      => Yii::t('coding', 'Mab'),
        ];
    }
    public function attributeHints() {
        return [
            'mab' => Yii::t('app', 'Toman')
        ];
    }
    public function setModel($model) {
        $this->_model = $model;
    }
    public function getModel() {
        return $this->_model;
    }
}