<?php
namespace app\modules\coding\models\DAL;
use Yii;
/**
 * This is the model class for table "view_list_forosh".
 * @author Hossein Najafi <hnajafi1994@gmail.com>
 *
 * @property int $id
 * @property int $id_p1
 * @property int $valint1
 * @property int $id_user1
 * @property int $id_user2
 * @property string $date1
 * @property string $date2
 * @property int $valint2
 * @property int $valint3
 * @property string $name1
 * @property int $valint4
 * @property int $valint5
 * @property int $valint6
 * @property int $valint7
 * @property int $valint8
 * @property int $valint9
 */
class ViewListForosh extends \yii\db\ActiveRecord {
    public static function tableName() {
        return 'view_list_forosh';
    }
    public function rules() {
        return [
                [['id', 'id_p1', 'valint1', 'id_user1', 'id_user2', 'valint2', 'valint3', 'valint4', 'valint5', 'valint6', 'valint7', 'valint8', 'valint9'], 'integer'],
                [['date1', 'date2'], 'safe'],
                [['name1'], 'string'],
        ];
    }
    public function attributeLabels() {
        return [
            'id' => Yii::t('coding', 'ID'),
            'id_p1' => Yii::t('coding', 'Id P1'),
            'valint1' => Yii::t('coding', 'Valint1'),
            'id_user1' => Yii::t('coding', 'Id User1'),
            'id_user2' => Yii::t('coding', 'Id User2'),
            'date1' => Yii::t('coding', 'Date1'),
            'date2' => Yii::t('coding', 'Date2'),
            'valint2' => Yii::t('coding', 'Valint2'),
            'valint3' => Yii::t('coding', 'Valint3'),
            'name1' => Yii::t('coding', 'Name1'),
            'valint4' => Yii::t('coding', 'Valint4'),
            'valint5' => Yii::t('coding', 'Valint5'),
            'valint6' => Yii::t('coding', 'Valint6'),
            'valint7' => Yii::t('coding', 'Valint7'),
            'valint8' => Yii::t('coding', 'Valint8'),
            'valint9' => Yii::t('coding', 'Valint9'),
        ];
    }
}