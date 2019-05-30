<?php
namespace app\modules\coding\controllers;
use Yii;
use yii\filters\AccessControl;
use app\config\widgets\Controller;
use app\config\components\functions;
use app\modules\coding\models\SRL\HesabhaSRL;
class HesabhaController extends Controller {
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'find'],
                        'roles' => ['Hesabha'],
                        'verbs' => ['GET']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['Hesabha'],
                        'verbs' => ['GET', 'POST']
                    ]
                ],
            ],
        ];
    }
    public function actionIndex() {
        $id_p1 = Yii::$app->request->get('id_p1');
        $id_p2 = Yii::$app->request->get('id_p2');
        $id_user1 = Yii::$app->request->get('id_user1');
        $model = HesabhaSRL::searchModel($id_p1, $id_p2, $id_user1);
        return $this->renderView([
            'model' => $model,
            'show' => $id_p1 || $id_p2 || $id_user1
        ]);
    }
    public function actionView($id) {
        $model = HesabhaSRL::findModel($id);
        if ($model == null) {
            functions::httpNotFound();
        }
        return $this->renderView($model);
    }
    public function actionCreate() {
        $model = HesabhaSRL::newViewModel();
        if (HesabhaSRL::insert($model, Yii::$app->request->post())) {
            return $this->redirectToView(['id' => $model->id]);
        }
        HesabhaSRL::loaditems($model);
        return $this->renderView($model);
    }
    public function actionFind($id) {
        $result = HesabhaSRL::find($id);
        return $this->asJson($result);
    }
}