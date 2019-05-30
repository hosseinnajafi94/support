<?php
namespace app\modules\users\controllers;
use Yii;
use yii\filters\AccessControl;
use app\config\widgets\Controller;
use app\config\components\functions;
use app\modules\users\models\SRL\UsersSRL;
class ProfileController extends Controller {
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['Profile'],
                        'verbs' => ['GET']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['password', 'update'],
                        'roles' => ['Profile'],
                        'verbs' => ['GET', 'POST']
                    ],
                ],
            ],
        ];
    }
    public function actionIndex() {
        $model = UsersSRL::findModel(Yii::$app->user->id);
        if ($model == null) {
            functions::httpNotFound();
        }
        return $this->renderView($model);
    }
    public function actionPassword() {
        $model = UsersSRL::findViewModel(Yii::$app->user->id, 'change-password');
        if (UsersSRL::update($model, Yii::$app->request->post())) {
            functions::setSuccessFlash();
            return $this->redirect(['index']);
        }
        return $this->renderView($model);
    }
    public function actionUpdate() {
        $model = UsersSRL::findViewModel(Yii::$app->user->id, 'update-profile');
        if (UsersSRL::update($model, Yii::$app->request->post())) {
            functions::setSuccessFlash();
            return $this->redirect(['index']);
        }
        return $this->renderView($model);
    }
}