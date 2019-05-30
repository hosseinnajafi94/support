<?php
namespace app\modules\coding\controllers;
use Yii;
use yii\filters\AccessControl;
use app\config\widgets\Controller;
use app\config\components\functions;
use app\modules\coding\models\SRL\TcodingSRL;
class TcodingController extends Controller {
    private $data = null;
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'verbs' => ['GET']        , 'actions' => ['index']     , 'roles' => ['Tcoding'], 'roleParams' => ['idnoe' => Yii::$app->request->get('idnoe')]],
                    ['allow' => true, 'verbs' => ['GET', 'POST'], 'actions' => ['create']    , 'roles' => ['Tcoding'], 'roleParams' => ['idnoe' => Yii::$app->request->get('idnoe')]],
                    ['allow' => true, 'verbs' => ['POST']       , 'actions' => ['discounts', 'account-balance', 'send', 'product-price']],
                    [
                        'allow'      => true,
                        'verbs'      => ['GET'],
                        'actions'    => ['view'],
                        'roles'      => ['Tcoding'],
                        'roleParams' => function() {
                            $id         = Yii::$app->request->get('id');
                            $this->data = TcodingSRL::findModel($id, 'view');
                            if ($this->data->model == null) {
                                return false;
                            }
                            return ['idnoe' => $this->data->idnoe];
                        },
                    ],
                    [
                        'allow'      => true,
                        'verbs'      => ['POST'],
                        'actions'    => ['delete'],
                        'roles'      => ['Tcoding'],
                        'roleParams' => function() {
                            $id         = Yii::$app->request->get('id');
                            $this->data = TcodingSRL::findModel($id, 'delete');
                            if ($this->data->model == null) {
                                return false;
                            }
                            return ['idnoe' => $this->data->idnoe];
                        },
                    ],
                    [
                        'allow'      => true,
                        'verbs'      => ['GET', 'POST'],
                        'actions'    => ['update'],
                        'roles'      => ['Tcoding'],
                        'roleParams' => function() {
                            $id         = Yii::$app->request->get('id');
                            $this->data = TcodingSRL::findViewModel($id);
                            if ($this->data->model == null) {
                                return false;
                            }
                            return ['idnoe' => $this->data->idnoe];
                        },
                    ],
                ],
            ],
        ];
    }
    public function actionIndex($idnoe) {
        $data = TcodingSRL::index($idnoe, Yii::$app->request->get());
        return $this->renderView($data);
    }
    public function actionView() {
        return $this->renderView($this->data);
    }
    public function actionCreate($idnoe) {
        $data = TcodingSRL::newViewModel($idnoe, Yii::$app->request->get());
        if (TcodingSRL::insert($data, Yii::$app->request->post())) {
            functions::setSuccessFlash();
            return $this->redirectToView(['id' => $data->viewmodel->id]);
        }
        TcodingSRL::loadItems($data);
        return $this->renderView($data);
    }
    public function actionUpdate() {
        $data = $this->data;
        if (TcodingSRL::update($data, Yii::$app->request->post())) {
            functions::setSuccessFlash();
            return $this->redirectToView(['id' => $data->viewmodel->id]);
        }
        TcodingSRL::loadItems($data);
        return $this->renderView($data);
    }
    public function actionDelete() {
        $data = TcodingSRL::delete($this->data);
        if ($data->saved) {
            functions::setSuccessFlash();
        }
        else {
            functions::setFailFlash();
        }
        return $this->redirect($data->redirect);
    }
    public function actionDiscounts() {
        $id    = Yii::$app->request->post('id');
        $date1 = functions::togdate(Yii::$app->request->post('date1'));
        $list  = TcodingSRL::getDiscounts($id, $date1);
        return $this->asJson(['saved' => true, 'list' => $list]);
    }
    public function actionAccountBalance() {
        $id                           = Yii::$app->request->post('id');
        list($saved, $val, $messages) = TcodingSRL::getAccountBalance($id);
        return $this->asJson(['saved' => $saved, 'val' => functions::toman($val), 'messages' => $messages]);
    }
    public function actionSend($id) {
        $sent = TcodingSRL::resendSaleSMS($id);
        if ($sent[0] === null) {
            $sent = TcodingSRL::resendSupportSMS($id);
            if ($sent[0] === null) {
                return functions::httpNotFound();
            }
        }
        $url = ['index', 'idnoe' => $sent[1]->id_noe];
        $module = Yii::$app->getModule('coding');
        if ($sent[1]->id_noe == $module->params['Support']) {
            $url['id_p1'] = $sent[1]->id_p1;
        }
        if ($sent[0] === false) {
            functions::setFailFlash();
        }
        else {
            functions::setSuccessFlash();
        }
        return $this->redirect($url);
    }
    public function actionProductPrice() {
        $id                           = Yii::$app->request->post('id');
        list($saved, $val, $messages) = TcodingSRL::getProductPrice($id);
        return $this->asJson(['saved' => $saved, 'val' => $val, 'messages' => $messages]);
    }
}