<?php
namespace app\modules\sms\controllers;
use Yii;
use yii\filters\AccessControl;
use app\config\widgets\Controller;
use app\config\components\functions;
use app\modules\sms\models\SRL\SmsSettingsSRL;
class SettingsController extends Controller {
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['SmsSettings'],
                        'verbs' => ['GET', 'POST']
                    ],
                ],
            ],
        ];
    }
    public function actionIndex() {
        $model = SmsSettingsSRL::findViewModel();
        if ($model->load(Yii::$app->request->post()) && SmsSettingsSRL::update($model)) {
            functions::setSuccessFlash();
            return $this->refresh();
        }
        return $this->render('index', [
                    'model' => $model,
        ]);
    }
}