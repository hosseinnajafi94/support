<?php
namespace app\modules\coding\models\DAL;
use Yii;
/**
 * This is the model class for table "view_list_kala".
 * @author Hossein Najafi <hnajafi1994@gmail.com>
 *
 * @property int $id
 * @property string $name1
 * @property int $id_p1
 * @property int $valint3
 * @property int $valint1
 * @property int $valint2
 */
class ViewListKala extends \yii\db\ActiveRecord {
    public static function tableName() {
        return 'view_list_kala';
    }
    public function rules() {
        return [
                [['id', 'id_p1', 'valint3', 'valint1', 'valint2'], 'integer'],
                [['name1'], 'string'],
        ];
    }
    public function attributeLabels() {
        return [
            'id' => Yii::t('coding', 'ID'),
            'name1' => Yii::t('coding', 'Name1'),
            'id_p1' => Yii::t('coding', 'Id P1'),
            'valint3' => Yii::t('coding', 'Valint3'),
            'valint1' => Yii::t('coding', 'Valint1'),
            'valint2' => Yii::t('coding', 'Valint2'),
        ];
    }
}