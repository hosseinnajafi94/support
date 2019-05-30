<?php
namespace app\modules\coding\models\DAL;
use Yii;
use app\modules\users\models\DAL\Users;
/**
 * This is the model class for table "hesabha".
 * @author Hossein Najafi <hnajafi1994@gmail.com>
 *
 * @property int $id
 * @property int $id_p1
 * @property int $id_p2
 * @property int $id_p3
 * @property int $id_user1
 * @property int $id_user2
 * @property int $bed
 * @property int $bes
 * @property int $mab
 * @property string $desc1
 * @property string $desc2
 * @property string $datetime
 * @property string $name1
 * @property string $date1
 *
 * @property Tcoding $p1
 * @property Tcoding $p2
 * @property Users $user1
 * @property Users $user2
 * @property Tcoding $p3
 */
class Hesabha extends \yii\db\ActiveRecord {
    public static function tableName() {
        return 'hesabha';
    }
    public function rules() {
        return [
                [['id_p1', 'id_p2', 'id_p3', 'id_user1', 'id_user2', 'bed', 'bes', 'mab'], 'integer'],
                [['id_user1', 'id_user2', 'bed', 'bes', 'mab', 'datetime'], 'required'],
                [['desc1', 'desc2'], 'string'],
                [['datetime', 'date1'], 'safe'],
                [['name1'], 'string', 'max' => 255],
                [['id_p1'], 'exist', 'skipOnError' => true, 'targetClass' => Tcoding::className(), 'targetAttribute' => ['id_p1' => 'id']],
                [['id_p2'], 'exist', 'skipOnError' => true, 'targetClass' => Tcoding::className(), 'targetAttribute' => ['id_p2' => 'id']],
                [['id_user1'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_user1' => 'id']],
                [['id_user2'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_user2' => 'id']],
                [['id_p3'], 'exist', 'skipOnError' => true, 'targetClass' => Tcoding::className(), 'targetAttribute' => ['id_p3' => 'id']],
        ];
    }
    public function attributeLabels() {
        return [
            'id' => Yii::t('coding', 'ID'),
            'id_p1' => Yii::t('coding', 'Id P1'),
            'id_p2' => Yii::t('coding', 'Id P2'),
            'id_p3' => Yii::t('coding', 'Id P3'),
            'id_user1' => Yii::t('coding', 'Id User1'),
            'id_user2' => Yii::t('coding', 'Id User2'),
            'bed' => Yii::t('coding', 'Bed'),
            'bes' => Yii::t('coding', 'Bes'),
            'mab' => Yii::t('coding', 'Mab'),
            'desc1' => Yii::t('coding', 'Desc1'),
            'desc2' => Yii::t('coding', 'Desc2'),
            'datetime' => Yii::t('coding', 'Datetime'),
            'name1' => Yii::t('coding', 'Name1'),
            'date1' => Yii::t('coding', 'Date1'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getP1() {
        return $this->hasOne(Tcoding::className(), ['id' => 'id_p1']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getP2() {
        return $this->hasOne(Tcoding::className(), ['id' => 'id_p2']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser1() {
        return $this->hasOne(Users::className(), ['id' => 'id_user1']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser2() {
        return $this->hasOne(Users::className(), ['id' => 'id_user2']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getP3() {
        return $this->hasOne(Tcoding::className(), ['id' => 'id_p3']);
    }
}