<?php
namespace app\modules\coding\models\DAL;
use Yii;
/**
 * This is the model class for table "view_list_vahed_kala".
 * @author Hossein Najafi <hnajafi1994@gmail.com>
 *
 * @property int $id
 * @property string $name1
 */
class ViewListVahedKala extends \yii\db\ActiveRecord {
    public static function tableName() {
        return 'view_list_vahed_kala';
    }
    public function rules() {
        return [
                [['id'], 'integer'],
                [['name1'], 'string'],
        ];
    }
    public function attributeLabels() {
        return [
            'id' => Yii::t('coding', 'ID'),
            'name1' => Yii::t('coding', 'Name1'),
        ];
    }
}