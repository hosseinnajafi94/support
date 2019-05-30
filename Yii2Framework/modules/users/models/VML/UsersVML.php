<?php
namespace app\modules\users\models\VML;
use Yii;
use yii\base\Model;
class UsersVML extends Model {
    public $id;
    public $old_password;
    public $new_password;
    public $new_password_repeat;
    public $can_login;
    public $username;
    public $fname;
    public $lname;
    public $email;
    public $mobile1;
    public $mobile2;
    public $phone1;
    public $phone2;
    public $address;
    public $group_id;
    public $_groups = [];
    public $ref_id;
    public $_refs   = [];
    public $roles   = [];
    public $_roles  = [];
    private $_model;
    public function rules() {
        return [
            [['old_password', 'new_password', 'new_password_repeat'], 'required', 'on' => ['change-password']],
            [['old_password', 'new_password', 'new_password_repeat'], 'string', 'max' => 255],
            [['username', 'fname', 'lname', 'mobile1', 'mobile2', 'phone1', 'phone2', 'address'], 'string', 'max' => 255],
            [['username'], 'default', 'value' => null],
            [['username'], 'required', 'on' => ['update-profile']],
            [['username'], 'required', 'on' => ['create', 'update'], 'when' => function ($model) {
                return $model->can_login == 1;
            }, 'whenClient' => "function(attribute){ return $('#' + attribute.id.replace('username', 'can_login')).prop('checked'); }"],
            [['fname', 'lname'], 'required', 'on' => ['create', 'update', 'update-profile']],
            [['roles'], 'each', 'rule' => ['safe']],
            [['can_login'], 'in', 'range' => [0, 1]],
            [['email'], 'email'],
            [['group_id', 'ref_id'], 'integer'],
            [['group_id'], 'required', 'on' => ['create', 'update']],
            [['email', 'mobile1', 'mobile2', 'phone1', 'phone2', 'address'], 'default', 'value' => null],
        ];
    }
    public function attributeLabels() {
        return [
            'old_password'        => Yii::t('users', 'Old Password'),
            'new_password'        => Yii::t('users', 'New Password'),
            'new_password_repeat' => Yii::t('users', 'New Password Repeat'),
            'group_id'            => Yii::t('users', 'Group ID'),
            'ref_id'              => Yii::t('users', 'Ref ID'),
            'can_login'           => Yii::t('users', 'Can Login'),
            'username'            => Yii::t('users', 'Username'),
            'fname'               => Yii::t('users', 'Fname'),
            'lname'               => Yii::t('users', 'Lname'),
            'email'               => Yii::t('users', 'Email'),
            'mobile1'             => Yii::t('users', 'Mobile1'),
            'mobile2'             => Yii::t('users', 'Mobile2'),
            'phone1'              => Yii::t('users', 'Phone1'),
            'phone2'              => Yii::t('users', 'Phone2'),
            'address'             => Yii::t('users', 'Address'),
            'roles'               => Yii::t('users', 'Permissions'),
        ];
    }
    public function setModel($model) {
        $this->_model = $model;
    }
    public function getModel() {
        return $this->_model;
    }
}