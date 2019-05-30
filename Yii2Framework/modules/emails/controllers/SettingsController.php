<?php
namespace app\modules\emails\controllers;
use Yii;
use yii\filters\AccessControl;
use app\config\widgets\Controller;
use app\config\components\functions;
use app\modules\emails\models\SRL\EmailsSettingsSRL;
class SettingsController extends Controller {
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['EmailSettings'],
                        'verbs' => ['GET', 'POST']
                    ],
                ],
            ],
        ];
    }
    public function actionIndex() {
        $model = EmailsSettingsSRL::findViewModel();
        if ($model->load(Yii::$app->request->post()) && EmailsSettingsSRL::update($model)) {
            functions::setSuccessFlash();
            return $this->refresh();
        }
        return $this->renderView($model);
    }
}