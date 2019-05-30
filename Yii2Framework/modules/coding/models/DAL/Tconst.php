<?php
namespace app\modules\coding\models\DAL;
use Yii;
/**
 * This is the model class for table "tconst".
 * @author Hossein Najafi <hnajafi1994@gmail.com>
 *
 * @property int $id
 * @property string $name
 *
 * @property Tcoding[] $tcodings
 */
class Tconst extends \yii\db\ActiveRecord {
    public static function tableName() {
        return 'tconst';
    }
    public function rules() {
        return [
                [['name'], 'required'],
                [['name'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels() {
        return [
            'id' => Yii::t('coding', 'ID'),
            'name' => Yii::t('coding', 'Name'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTcodings() {
        return $this->hasMany(Tcoding::className(), ['id_noe' => 'id']);
    }
}