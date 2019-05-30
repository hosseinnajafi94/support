<?php
namespace app\modules\coding\models\DAL;
use Yii;
use app\modules\users\models\DAL\Users;
/**
 * This is the model class for table "tcoding".
 * @author Hossein Najafi <hnajafi1994@gmail.com>
 *
 * @property int $id
 * @property int $id_noe
 * @property int $deleted
 * @property int $id_p1
 * @property int $id_p2
 * @property int $id_p3
 * @property int $id_p4
 * @property int $id_p5
 * @property int $id_user1
 * @property int $id_user2
 * @property int $id_user3
 * @property int $id_user4
 * @property int $id_user5
 * @property string $name1
 * @property string $name2
 * @property string $name3
 * @property string $name4
 * @property string $name5
 * @property int $valint1
 * @property int $valint2
 * @property int $valint3
 * @property int $valint4
 * @property int $valint5
 * @property int $valint6
 * @property int $valint7
 * @property int $valint8
 * @property int $valint9
 * @property int $valint10
 * @property string $date1
 * @property string $date2
 * @property string $date3
 * @property string $date4
 * @property string $date5
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 *
 * @property Tconst $noe
 * @property Users $user1
 * @property Users $user2
 * @property Users $user3
 * @property Users $user4
 * @property Users $user5
 * @property Tcoding $p1
 * @property Tcoding[] $tcodings1
 * @property Tcoding $p2
 * @property Tcoding[] $tcodings2
 * @property Tcoding $p3
 * @property Tcoding[] $tcodings3
 * @property Tcoding $p4
 * @property Tcoding[] $tcodings4
 * @property Tcoding $p5
 * @property Tcoding[] $tcodings5
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class Tcoding extends \yii\db\ActiveRecord {
    public static function tableName() {
        return 'tcoding';
    }
    public function rules() {
        return [
                [['id_noe', 'deleted', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'required'],
                [['id_noe', 'deleted', 'id_p1', 'id_p2', 'id_p3', 'id_p4', 'id_p5', 'id_user1', 'id_user2', 'id_user3', 'id_user4', 'id_user5', 'valint1', 'valint2', 'valint3', 'valint4', 'valint5', 'valint6', 'valint7', 'valint8', 'valint9', 'valint10', 'created_by', 'updated_by'], 'integer'],
                [['name1', 'name2', 'name3', 'name4', 'name5'], 'string'],
                [['date1', 'date2', 'date3', 'date4', 'date5', 'created_at', 'updated_at'], 'safe'],
                [['id_noe'], 'exist', 'skipOnError' => true, 'targetClass' => Tconst::className(), 'targetAttribute' => ['id_noe' => 'id']],
                [['id_user1'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_user1' => 'id']],
                [['id_user2'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_user2' => 'id']],
                [['id_user3'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_user3' => 'id']],
                [['id_user4'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_user4' => 'id']],
                [['id_user5'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_user5' => 'id']],
                [['id_p1'], 'exist', 'skipOnError' => true, 'targetClass' => Tcoding::className(), 'targetAttribute' => ['id_p1' => 'id']],
                [['id_p2'], 'exist', 'skipOnError' => true, 'targetClass' => Tcoding::className(), 'targetAttribute' => ['id_p2' => 'id']],
                [['id_p3'], 'exist', 'skipOnError' => true, 'targetClass' => Tcoding::className(), 'targetAttribute' => ['id_p3' => 'id']],
                [['id_p4'], 'exist', 'skipOnError' => true, 'targetClass' => Tcoding::className(), 'targetAttribute' => ['id_p4' => 'id']],
                [['id_p5'], 'exist', 'skipOnError' => true, 'targetClass' => Tcoding::className(), 'targetAttribute' => ['id_p5' => 'id']],
                [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'id']],
                [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }
    public function attributeLabels() {
        return [
            'id' => Yii::t('coding', 'ID'),
            'id_noe' => Yii::t('coding', 'Id Noe'),
            'deleted' => Yii::t('coding', 'Deleted'),
            'id_p1' => Yii::t('coding', 'Id P1'),
            'id_p2' => Yii::t('coding', 'Id P2'),
            'id_p3' => Yii::t('coding', 'Id P3'),
            'id_p4' => Yii::t('coding', 'Id P4'),
            'id_p5' => Yii::t('coding', 'Id P5'),
            'id_user1' => Yii::t('coding', 'Id User1'),
            'id_user2' => Yii::t('coding', 'Id User2'),
            'id_user3' => Yii::t('coding', 'Id User3'),
            'id_user4' => Yii::t('coding', 'Id User4'),
            'id_user5' => Yii::t('coding', 'Id User5'),
            'name1' => Yii::t('coding', 'Name1'),
            'name2' => Yii::t('coding', 'Name2'),
            'name3' => Yii::t('coding', 'Name3'),
            'name4' => Yii::t('coding', 'Name4'),
            'name5' => Yii::t('coding', 'Name5'),
            'valint1' => Yii::t('coding', 'Valint1'),
            'valint2' => Yii::t('coding', 'Valint2'),
            'valint3' => Yii::t('coding', 'Valint3'),
            'valint4' => Yii::t('coding', 'Valint4'),
            'valint5' => Yii::t('coding', 'Valint5'),
            'valint6' => Yii::t('coding', 'Valint6'),
            'valint7' => Yii::t('coding', 'Valint7'),
            'valint8' => Yii::t('coding', 'Valint8'),
            'valint9' => Yii::t('coding', 'Valint9'),
            'valint10' => Yii::t('coding', 'Valint10'),
            'date1' => Yii::t('coding', 'Date1'),
            'date2' => Yii::t('coding', 'Date2'),
            'date3' => Yii::t('coding', 'Date3'),
            'date4' => Yii::t('coding', 'Date4'),
            'date5' => Yii::t('coding', 'Date5'),
            'created_at' => Yii::t('coding', 'Created At'),
            'created_by' => Yii::t('coding', 'Created By'),
            'updated_at' => Yii::t('coding', 'Updated At'),
            'updated_by' => Yii::t('coding', 'Updated By'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoe() {
        return $this->hasOne(Tconst::className(), ['id' => 'id_noe']);
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
    public function getUser3() {
        return $this->hasOne(Users::className(), ['id' => 'id_user3']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser4() {
        return $this->hasOne(Users::className(), ['id' => 'id_user4']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser5() {
        return $this->hasOne(Users::className(), ['id' => 'id_user5']);
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
    public function getTcodings1() {
        return $this->hasMany(Tcoding::className(), ['id_p1' => 'id']);
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
    public function getP2() {
        return $this->hasOne(Tcoding::className(), ['id' => 'id_p2']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTcodings2() {
        return $this->hasMany(Tcoding::className(), ['id_p2' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getP3() {
        return $this->hasOne(Tcoding::className(), ['id' => 'id_p3']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTcodings3() {
        return $this->hasMany(Tcoding::className(), ['id_p3' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getP4() {
        return $this->hasOne(Tcoding::className(), ['id' => 'id_p4']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTcodings4() {
        return $this->hasMany(Tcoding::className(), ['id_p4' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getP5() {
        return $this->hasOne(Tcoding::className(), ['id' => 'id_p5']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTcodings5() {
        return $this->hasMany(Tcoding::className(), ['id_p5' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(Users::className(), ['id' => 'created_by']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy() {
        return $this->hasOne(Users::className(), ['id' => 'updated_by']);
    }
}