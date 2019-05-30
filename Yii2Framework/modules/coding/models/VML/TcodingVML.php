<?php
namespace app\modules\coding\models\VML;
use Yii;
use yii\base\Model;
class TcodingVML extends Model {
    public $id;
    public $id_noe;
    public $deleted;
    public $id_p1;
    public $id_p2;
    public $id_p3;
    public $id_p4;
    public $id_p5;
    public $id_user1;
    public $id_user2;
    public $id_user3;
    public $id_user4;
    public $id_user5;
    public $name1;
    public $name2;
    public $name3;
    public $name4;
    public $name5;
    public $valint1;
    public $valint2;
    public $valint3;
    public $valint4;
    public $valint5;
    public $valint6;
    public $valint7;
    public $valint8;
    public $valint9;
    public $valint10;
    public $date1;
    public $date2;
    public $date3;
    public $date4;
    public $date5;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $users1 = [];
    public $users2 = [];
    public $users3 = [];
    public $users4 = [];
    public $users5 = [];
    public $p1s    = [];
    public $p2s    = [];
    public $p3s    = [];
    public $p4s    = [];
    public $p5s    = [];
    public $rules  = [];
    public $labels = [];
    public $hints  = [];
    public $models = [];
    public $model;
    public function rules() {
        return $this->rules;
    }
    public function attributeLabels() {
        return $this->labels;
    }
    public function attributeHints() {
        return $this->hints;
    }
    public function checkIsArray() {
        if (count($this->models) == 0) {
            $this->addError('models', Yii::t('coding', 'No Kala was found.'));
        }
        else {
            $outs = 0;
            foreach ($this->models as $model) {
                if ($model->valint1 == 1) {
                    $outs++;
                    break;
                }
            }
            if ($outs == 0) {
                $this->addError('models', Yii::t('coding', 'Select at least one room.'));
            }
        }
    }
}