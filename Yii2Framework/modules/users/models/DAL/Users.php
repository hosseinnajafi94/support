<?php
namespace app\modules\users\models\DAL;
use Yii;
use app\modules\coding\models\DAL\Tcoding;
/**
 * This is the model class for table "users".
 * @author Hossein Najafi <hnajafi1994@gmail.com>
 *
 * @property int $id
 * @property int $status_id
 * @property int $group_id
 * @property int $ref_id
 * @property int $can_login
 * @property string $username
 * @property string $password_hash
 * @property string $fname
 * @property string $lname
 * @property string $email
 * @property string $mobile1
 * @property string $mobile2
 * @property string $phone1
 * @property string $phone2
 * @property string $address
 * @property string $avatar
 * @property string $auth_key
 * @property string $password_reset_token
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 *
 * @property Tcoding[] $tcodings
 * @property Tcoding[] $tcodings0
 * @property Tcoding[] $tcodings1
 * @property Tcoding[] $tcodings2
 * @property Tcoding[] $tcodings3
 * @property Tcoding[] $tcodings4
 * @property Tcoding[] $tcodings5
 * @property UsersStatus $status
 * @property UsersGroups $group
 * @property Users $createdBy
 * @property Users[] $users
 * @property Users $updatedBy
 * @property Users[] $users0
 * @property Users $ref
 * @property Users[] $users1
 */
class Users extends \yii\db\ActiveRecord {
    public static function tableName() {
        return 'users';
    }
    public function rules() {
        return [
                [['status_id', 'group_id', 'password_hash', 'fname', 'lname', 'avatar', 'auth_key', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'required'],
                [['status_id', 'group_id', 'ref_id', 'can_login', 'created_by', 'updated_by'], 'integer'],
                [['created_at', 'updated_at'], 'safe'],
                [['username', 'password_hash', 'fname', 'lname', 'email', 'mobile1', 'mobile2', 'phone1', 'phone2', 'address', 'avatar', 'password_reset_token'], 'string', 'max' => 255],
                [['auth_key'], 'string', 'max' => 32],
                [['auth_key'], 'unique'],
                [['username'], 'unique'],
                [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsersStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
                [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsersGroups::className(), 'targetAttribute' => ['group_id' => 'id']],
                [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'id']],
                [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'id']],
                [['ref_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['ref_id' => 'id']],
        ];
    }
    public function attributeLabels() {
        return [
            'id' => Yii::t('users', 'ID'),
            'status_id' => Yii::t('users', 'Status ID'),
            'group_id' => Yii::t('users', 'Group ID'),
            'ref_id' => Yii::t('users', 'Ref ID'),
            'can_login' => Yii::t('users', 'Can Login'),
            'username' => Yii::t('users', 'Username'),
            'password_hash' => Yii::t('users', 'Password Hash'),
            'fname' => Yii::t('users', 'Fname'),
            'lname' => Yii::t('users', 'Lname'),
            'email' => Yii::t('users', 'Email'),
            'mobile1' => Yii::t('users', 'Mobile1'),
            'mobile2' => Yii::t('users', 'Mobile2'),
            'phone1' => Yii::t('users', 'Phone1'),
            'phone2' => Yii::t('users', 'Phone2'),
            'address' => Yii::t('users', 'Address'),
            'avatar' => Yii::t('users', 'Avatar'),
            'auth_key' => Yii::t('users', 'Auth Key'),
            'password_reset_token' => Yii::t('users', 'Password Reset Token'),
            'created_at' => Yii::t('users', 'Created At'),
            'created_by' => Yii::t('users', 'Created By'),
            'updated_at' => Yii::t('users', 'Updated At'),
            'updated_by' => Yii::t('users', 'Updated By'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTcodings() {
        return $this->hasMany(Tcoding::className(), ['id_user2' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTcodings0() {
        return $this->hasMany(Tcoding::className(), ['id_user3' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTcodings1() {
        return $this->hasMany(Tcoding::className(), ['id_user4' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTcodings2() {
        return $this->hasMany(Tcoding::className(), ['id_user5' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTcodings3() {
        return $this->hasMany(Tcoding::className(), ['created_by' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTcodings4() {
        return $this->hasMany(Tcoding::className(), ['updated_by' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTcodings5() {
        return $this->hasMany(Tcoding::className(), ['id_user1' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus() {
        return $this->hasOne(UsersStatus::className(), ['id' => 'status_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup() {
        return $this->hasOne(UsersGroups::className(), ['id' => 'group_id']);
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
    public function getUsers() {
        return $this->hasMany(Users::className(), ['created_by' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy() {
        return $this->hasOne(Users::className(), ['id' => 'updated_by']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers0() {
        return $this->hasMany(Users::className(), ['updated_by' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRef() {
        return $this->hasOne(Users::className(), ['id' => 'ref_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers1() {
        return $this->hasMany(Users::className(), ['ref_id' => 'id']);
    }
}