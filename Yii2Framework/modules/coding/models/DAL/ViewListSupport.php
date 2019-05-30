<?php
namespace app\modules\coding\models\DAL;
use Yii;
/**
 * This is the model class for table "view_list_support".
 * @author Hossein Najafi <hnajafi1994@gmail.com>
 *
 * @property int $id
 * @property int $id_p1
 * @property int $id_p2
 * @property string $date1
 * @property string $date2
 * @property int $valint1
 */
class ViewListSupport extends \yii\db\ActiveRecord {
    public static function tableName() {
        return 'view_list_support';
    }
    public function rules() {
        return [
                [['id', 'id_p1', 'id_p2', 'valint1'], 'integer'],
                [['date1', 'date2'], 'safe'],
        ];
    }
    public function attributeLabels() {
        return [
            'id' => Yii::t('coding', 'ID'),
            'id_p1' => Yii::t('coding', 'Id P1'),
            'id_p2' => Yii::t('coding', 'Id P2'),
            'date1' => Yii::t('coding', 'Date1'),
            'date2' => Yii::t('coding', 'Date2'),
            'valint1' => Yii::t('coding', 'Valint1'),
        ];
    }
}