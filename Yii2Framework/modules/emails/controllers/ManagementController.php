<?php
namespace app\modules\emails\controllers;
use Yii;
use yii\filters\AccessControl;
use app\config\widgets\Controller;
use app\config\components\functions;
use app\modules\emails\models\SRL\EmailsSRL;
class ManagementController extends Controller {
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['Email'],
                        'verbs' => ['GET']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['send'],
                        'roles' => ['Email'],
                        'verbs' => ['GET', 'POST']
                    ],
                ],
            ],
        ];
    }
    public function actionIndex() {
        $model = EmailsSRL::searchModel();
        return $this->renderView($model);
    }
    public function actionView($id) {
        $model = EmailsSRL::findModel($id);
        if ($model == null) {
            functions::httpNotFound();
        }
        return $this->renderView($model);
    }
    public function actionSend() {
        $model = EmailsSRL::newViewModel();
        if ($model->load(Yii::$app->request->post()) && EmailsSRL::insert($model)) {
            functions::setSuccessFlash(Yii::t('emails', 'Email Sent Successfully.'));
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->renderView($model);
    }
}