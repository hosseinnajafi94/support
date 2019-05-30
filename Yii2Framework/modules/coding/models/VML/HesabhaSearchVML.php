<?php
namespace app\modules\coding\models\VML;
use yii\base\Model;
class HesabhaSearchVML extends Model {
    public $id_p1;
    public $id_p2;
    public $id_user;
    public function rules() {
        return [
            [['id_p1', 'id_p2', 'id_user'], 'integer'],
        ];
    }
}