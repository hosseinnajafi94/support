<?php
namespace app\modules\coding\models\VML;
use Yii;
use yii\base\Model;
class HesabhaVML extends Model {
    public $id;
    public $valint1 = '0';
    public $id_p2;
    public $id_p3;
    public $id_user1;
    public $id_user2;
    public $name1;
    public $date1;
    public $mab;
    public $desc2;
    public $users = [];
    public $ps   = [];
    public $ps2   = [];
    private $_model;
    public function rules() {
        return [
                [['id_user1', 'id_user2', 'mab'], 'required'],
                [['id_p2', 'id_p3', 'id_user1', 'id_user2', 'mab'], 'integer'],
                [['date1'], 'safe'],
                [['desc2'], 'string'],
                [['name1'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels() {
        return [
            'id_p2'    => Yii::t('coding', 'Hesab Bedehkari'),
            'id_p3'    => Yii::t('coding', 'NoeDaryaftPardakht'),
            'name1'    => Yii::t('coding', 'Shomareh Check'),
            'date1'    => Yii::t('coding', 'Tarikh Sar Resid'),
            'id_user1' => Yii::t('coding', 'Id User1'),
            'id_user2' => Yii::t('coding', 'Id User2'),
            'mab'      => Yii::t('coding', 'Mab'),
            'desc2'    => Yii::t('coding', 'Hesab Desc2'),
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