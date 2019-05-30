<?php
namespace app\modules\users\controllers;
use Yii;
use app\config\widgets\Controller;
use app\modules\users\models\SRL\AuthSRL;
class AuthController extends Controller {
    public function beforeAction($action) {
        $this->layout = '@app/layouts/login';
        return parent::beforeAction($action);
    }
    public function actions() {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_DEBUG ? '2020' : null,
            ],
        ];
    }
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/dashboard/default/index']);
        }
        $model = AuthSRL::newLoginViewModel();
        if ($model->load(Yii::$app->request->post()) && AuthSRL::login($model)) {
            return $this->redirect(['/dashboard/default/index']);
        }
        return $this->renderView($model);
    }
    public function actionLogout() {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
        }
        return $this->redirect(['login']);
        //return $this->redirect(['/site/default/index']);
    }
}