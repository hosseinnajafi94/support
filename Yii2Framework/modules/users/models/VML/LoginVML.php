<?php
namespace app\modules\users\models\VML;
use Yii;
use yii\base\Model;
class LoginVML extends Model {
    public $username;
    /**
     * @var string Password
     */
    public $password;
    /**
     * @var captcha Captcha
     */
    public $captcha;
    /**
     * @var bool Remember Me
     */
    public $rememberMe = true;
    public function rules() {
        return [
            [['username', 'password'], 'required'],
            [['username', 'password'], 'string', 'max' => 255],
            [['captcha'], 'captcha', 'captchaAction' => '/users/auth/captcha'],
            [['rememberMe'], 'boolean'],
        ];
    }
    public function attributeLabels() {
        return [
            'username'   => Yii::t('users', 'Username'),
            'password'   => Yii::t('users', 'Password'),
            'captcha'    => Yii::t('users', 'Captcha'),
            'rememberMe' => Yii::t('users', 'Remember Me'),
        ];
    }
}