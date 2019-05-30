<?php
namespace app\modules\site\controllers;
use Yii;
use app\config\widgets\Controller;
use app\config\widgets\ArrayHelper;
use app\config\components\functions;
use app\config\components\DARGAH_MELLAT;
use app\config\components\DARGAH_IRANKISH;
use app\config\components\DARGAH_ZARINPAL;
use app\modules\coding\models\DAL\Tcoding;
use app\modules\coding\models\SRL\ReservationsSRL;
use app\modules\site\models\SRL\SiteSettingsSRL;
class DefaultController extends Controller {
    /**
     * @var \app\modules\site\models\DAL\SiteSettings Site Settings Model
     */
    public $settings;
    public function beforeAction($action) {
        $this->settings = SiteSettingsSRL::get();
        $this->layout   = '@app/layouts/site';
        if (Yii::$app->controller->action->id == 'callback') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
    public function actions() {
        return [
            'error' => [
                'class'  => 'yii\web\ErrorAction',
                'layout' => '@app/layouts/site',
                'layout' => Yii::$app->user->isGuest ? '@app/layouts/site' : '@app/layouts/admin'
            ],
        ];
    }
    public function actionIndex() {
        if (Yii::$app->request->isAjax) {
            $done     = false;
            $data     = [];
            $messages = [];
            switch (Yii::$app->request->post('type')) {
                case 'get list':
                    $date1 = functions::togdate(Yii::$app->request->post('date1'));
                    $date2 = functions::togdate(Yii::$app->request->post('date2'));
                    if ($date1 && $date2) {
                        $time1 = strtotime($date1);
                        $time2 = strtotime($date2);
                        if (date('Y-m-d', $time1) == $date1 && date('Y-m-d', $time2) == $date2) {
                            $done = true;
                            $rows = ReservationsSRL::getRooms($date1, $date2);
                            foreach ($rows as $row) {
                                $data[] = [
                                    'id'      => $row['id'],
                                    'name1'   => $row['name1'],
                                    'name3'   => $row['name3'],
                                    'valint1' => $row['valint1'],
                                    'valint2' => $row['valint2'],
                                    'valint3' => $row['valint3'],
                                    'valint4' => $row['valint4'],
                                    'valint5' => $row['valint5'],
                                ];
                            }
                        }
                        else {
                            $messages[] = Yii::t('site', 'Please enter the date of arrival and departure.');
                        }
                    }
                    else {
                        $messages[] = Yii::t('site', 'Please enter the date of arrival and departure.');
                    }
                    break;
                case 'validate':
                    $id    = Yii::$app->request->post('id');
                    $date1 = functions::togdate(Yii::$app->request->post('date1'));
                    $date2 = functions::togdate(Yii::$app->request->post('date2'));
                    if ($date1 && $date2 && is_numeric($id)) {
                        $time1 = strtotime($date1);
                        $time2 = strtotime($date2);
                        if (date('Y-m-d', $time1) == $date1 && date('Y-m-d', $time2) == $date2) {
                            $row = ReservationsSRL::getRooms($date1, $date2, $id);
                            if ($row === null) {
                                $messages[] = Yii::t('site', 'Please enter the date of arrival and departure.');
                            }
                            else {
                                $done = true;
                            }
                        }
                        else {
                            $messages[] = Yii::t('site', 'Please enter the date of arrival and departure.');
                        }
                    }
                    else {
                        $messages[] = Yii::t('site', 'Please enter the date of arrival and departure.');
                    }
                    break;
                case 'tracking':
                    $date1 = functions::togdate(Yii::$app->request->post('date1'));
                    $name1 = Yii::$app->request->post('name1');
                    $time1 = strtotime($date1);
                    if (date('Y-m-d', $time1) == $date1 && $name1) {
                        $row = ReservationsSRL::getRoom($date1, $name1);
                        if ($row === null) {
                            $messages[] = Yii::t('site', 'Please enter the date of arrival and departure.');
                        }
                        else {
                            $done      = true;
                            $data['t'] = $row->id;
                            $data['n'] = $row->name1;
                        }
                    }
                    else {
                        $messages[] = Yii::t('site', 'Please enter the date of arrival and departure.');
                    }
                    break;
                default :
                    return functions::httpNotFound();
            }
            return $this->asJson(['done' => $done, 'data' => $data, 'messages' => $messages]);
        }
        return $this->renderView([
        ]);
    }
    public function actionInfo() {
        list($model, $title) = ReservationsSRL::newViewModel();
        $model->date1 = functions::togdate(Yii::$app->request->post('date1'));
        $model->date2 = functions::togdate(Yii::$app->request->post('date2'));
        $model->id_p2 = Yii::$app->request->post('id', null);
        if ($model->load(Yii::$app->request->post()) && ReservationsSRL::insertUser($model, $this->settings)) {
            return $this->redirect(['pay', 'n' => $model->name1, 't' => $model->id]);
        }
        $model->room = Tcoding::findOne(['deleted' => 0, 'id_noe' => 2, 'id' => $model->id_p2]);
        if ($model->room === null) {
            return functions::httpNotFound();
        }
        $discounts = ReservationsSRL::getDiscounts($model->date1, $model->id_p2);
        if ($discounts) {
            $model->discount = $discounts[0];
            $model->id_p3    = $model->discount->id;
        }
        ReservationsSRL::calc($model, $model);
        return $this->renderView([
                    'model' => $model,
        ]);
    }
    public function actionPay($n, $t) {
        $model = ReservationsSRL::find($n, $t);
        if ($model == null) {
            return functions::httpNotFound();
        }
        return $this->renderView($model);
    }
    public function actionStartPay($n, $t) {
        /* @var $model \app\modules\coding\models\DAL\Reservations */
        $model = ReservationsSRL::find($n, $t);
        if ($model == null) {
            return functions::httpNotFound();
        }
        $session = Yii::$app->session;
        $action   = $method   = $description = '';
        $items    = [];
        $orderId  = $model->id;
        $mobile   = $model->name4;
        $email    = $model->name5;
        $amount   = $model->valint9;
        $settings = $this->settings;
        $callback = ['/site/default/callback', 'gateway' => $settings->default_gateway, 'reservId' => $model->id];
        if ($settings->default_gateway == 1) {
            $terminal = $settings->mellat_terminal;
            $username = $settings->mellat_username;
            $password = $settings->mellat_password;
            $method   = 'post';
            list($isOK, $items, $action) = DARGAH_MELLAT::send($terminal, $username, $password, $orderId, $amount, $callback);
            if (!$isOK) {
                return $this->render('gateway-error');
            }
            $model->gateway = 1;
            $model->mellat_ref_id = $items['RefId'];
            $model->save();
            $session->set('mellat_ref_id', $model->mellat_ref_id);
        }
        else if ($settings->default_gateway == 2) {
            $merchant_id = $settings->irankish_merchant_id;
            $method      = 'post';
            list($isOK, $items, $action) = DARGAH_IRANKISH::send($merchant_id, $amount, $description, $callback);
            if (!$isOK) {
                return $this->render('gateway-error');
            }
            $model->gateway = 2;
            $model->irankish_token = $items['token'];
            $model->save();
            $session->set('irankish_token', $model->irankish_token);
        }
        else if ($settings->default_gateway == 3) {
            $merchant_id = $settings->zarinpal_merchant_id;
            $method      = 'get';
            list($isOK, $items, $action) = DARGAH_ZARINPAL::send($merchant_id, $amount, $description, $callback, $email, $mobile);
            if (!$isOK) {
                return $this->render('gateway-error');
            }
            $model->gateway = 3;
            $model->zarinpal_authority = ArrayHelper::remove($items, 'Authority');
            $model->save();
            $session->set('zarinpal_authority', $model->zarinpal_authority);
        }
        else {
            return $this->render('gateway-error');
        }
        return $this->renderView(['model' => $model, 'action' => $action, 'method' => $method, 'items' => $items]);
    }
    public function actionCallback($gateway, $reservId) {
        $settings = $this->settings;
        $session = Yii::$app->session;
        $id = null;
        $ref = null;
        if ($gateway == 1) {
            $mellat_ref_id = $session->get('mellat_ref_id');
            
            /* @var $model \app\modules\coding\models\DAL\Reservations */
            $model = ReservationsSRL::get(['id' => $reservId, 'id_p1' => 1, 'gateway' => 1, 'mellat_ref_id' => $mellat_ref_id]);
            if ($model == null) {
                return functions::httpNotFound();
            }
            $session->remove('mellat_ref_id');
            
            $ResCode = Yii::$app->request->post('ResCode');
            $SaleOrderId = Yii::$app->request->post('SaleOrderId');
            $SaleReferenceId = Yii::$app->request->post('SaleReferenceId');
            
            list($isOK, $items) = DARGAH_MELLAT::verify(
                $settings->mellat_terminal, $settings->mellat_username, $settings->mellat_password,
                $ResCode, $SaleOrderId, $SaleReferenceId
            );
            if (!$isOK) {
                return $this->redirect(['pay-result', 'id' => $model->id, 'ref' => $model->mellat_ref_id]);
            }

            $model->id_p1 = 2;
            $model->mellat_res_code = $items['resCode'];
            $model->mellat_sale_order_id = $items['saleOrderId'];
            $model->mellat_reference_id = $items['saleReferenceId'];
            $model->save();
            
            $id = $model->id;
            $ref = $model->mellat_reference_id;
        }
        else if ($gateway == 2) {
            $irankish_token = $session->get('irankish_token');
            
            /* @var $model \app\modules\coding\models\DAL\Reservations */
            $model = ReservationsSRL::get(['id' => $reservId, 'id_p1' => 1, 'gateway' => 2, 'irankish_token' => $irankish_token]);
            if ($model == null) {
                return functions::httpNotFound();
            }
            $session->remove('irankish_token');
            
            $resultCode = Yii::$app->request->post('resultCode');
            $referenceId = Yii::$app->request->post('referenceId', '0');
            
            list($isOK, $items) = DARGAH_IRANKISH::verify($settings->irankish_merchant_id, $settings->irankish_sha1Key, $resultCode, $referenceId, $model->valint9, $model->irankish_token);
            if (!$isOK) {
                return $this->redirect(['pay-result', 'id' => $model->id, 'ref' => $model->irankish_token]);
            }
            
            $model->id_p1 = 2;
            $model->irankish_result_code = $items['resultCode'];
            $model->irankish_reference_id = $items['referenceId'];
            $model->save();
            
            $id = $model->id;
            $ref = $model->irankish_reference_id;
        }
        else if ($gateway == 3) {
            $zarinpal_authority = $session->get('zarinpal_authority');
            
            /* @var $model \app\modules\coding\models\DAL\Reservations */
            $model = ReservationsSRL::get(['id' => $reservId, 'id_p1' => 1, 'gateway' => 3, 'zarinpal_authority' => $zarinpal_authority]);
            if ($model == null) {
                return functions::httpNotFound();
            }
            $session->remove('zarinpal_authority');
            
            list($isOK, $items) = DARGAH_ZARINPAL::verify($settings->zarinpal_merchant_id, $model->zarinpal_authority, $model->valint9);
            if (!$isOK) {
                return $this->redirect(['pay-result', 'id' => $model->id, 'ref' => $model->zarinpal_authority]);
            }
            
            $model->id_p1 = 2;
            $model->zarinpal_ref_id = $items['RefID'];
            $model->save();
            
            $id = $model->id;
            $ref = $model->zarinpal_ref_id;
        }
        else {
            return functions::httpNotFound();
        }
        ReservationsSRL::Messenger($settings, $model);
        return $this->redirect(['factor', 'id' => $id, 'ref' => $ref]);
    }
    public function actionPayResult($id, $ref) {
        /* @var $model \app\modules\coding\models\DAL\Reservations */
        $model = ReservationsSRL::get(['id' => $id, 'id_p1' => 1]);
        if ($model == null) {
            return functions::httpNotFound();
        }
        if (
            ($model->gateway == 1 && $model->mellat_ref_id == $ref)
         || ($model->gateway == 2 && $model->irankish_token == $ref)
         || ($model->gateway == 3 && $model->zarinpal_authority == $ref)
        ) {
            return $this->renderView(['model' => $model, 'ref' => $ref]);
        }
        return functions::httpNotFound();
    }
    public function actionFactor($id, $ref) {
        /* @var $model \app\modules\coding\models\DAL\Reservations */
        $model = ReservationsSRL::get(['id' => $id, 'id_p1' => 2]);
        if ($model == null) {
            return functions::httpNotFound();
        }
        if (
            ($model->gateway == 1 && $model->mellat_reference_id == $ref)
         || ($model->gateway == 2 && $model->irankish_reference_id == $ref)
         || ($model->gateway == 3 && $model->zarinpal_ref_id == $ref)
        ) {
            return $this->renderView([
                'model' => $model,
                'ref' => $ref,
            ]);
        }
        return functions::httpNotFound();
    }
}