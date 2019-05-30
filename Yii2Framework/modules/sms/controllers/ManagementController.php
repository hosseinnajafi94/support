<?php
namespace app\modules\sms\controllers;
use Yii;
use yii\filters\AccessControl;
use app\config\widgets\Controller;
use app\config\components\functions;
use app\modules\sms\models\SRL\SmsSRL;
class ManagementController extends Controller {
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['Sms'],
                        'verbs' => ['GET']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['send'],
                        'roles' => ['Sms'],
                        'verbs' => ['GET', 'POST']
                    ],
                ],
            ],
        ];
    }
    public function actionIndex() {
        $dataProvider = SmsSRL::searchModel();
        return $this->renderView($dataProvider);
    }
    public function actionView($id) {
        $model = SmsSRL::findModel($id);
        if ($model == null) {
            functions::httpNotFound();
        }
        return $this->renderView($model);
    }
    public function actionSend() {
        $model = SmsSRL::newViewModel();
        if ($model->load(Yii::$app->request->post()) && SmsSRL::insert($model)) {
            functions::setSuccessFlash(Yii::t('sms', 'Sms Sent Successfully.'));
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->renderView($model);
    }
}