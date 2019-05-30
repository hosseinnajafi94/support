<?php
namespace app\modules\dashboard\controllers;
use Yii;
use yii\filters\AccessControl;
use app\config\widgets\Controller;
use app\config\widgets\ArrayHelper;
use app\config\components\functions;
use app\config\components\DARGAH_ZARINPAL;
use app\modules\coding\models\DAL\Tcoding;
use app\modules\coding\models\VML\HesabhaVML2;
use app\modules\coding\models\DAL\Payments;
use app\modules\site\models\SRL\SiteSettingsSRL;
use app\modules\coding\models\DAL\Hesabha;
use app\modules\users\models\SRL\UsersSRL;
class DefaultController extends Controller {
    public function behaviors2() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                        [
                        'allow'   => true,
                        'actions' => ['index'],
                        'roles'   => ['Dashboard'],
                        'verbs'   => ['GET', 'POST']
                    ],
                ],
            ],
        ];
    }
    public function actionIndex() {
//        $user = UsersSRL::findModel(Yii::$app->user->id);
        $user = Yii::$app->user->identity;
        $userId = $user->id;
        
        $model = new HesabhaVML2();
        if ($model->load(Yii::$app->request->post())) {
            $row    = Tcoding::find()->from('view_list_h2')->where('valint1>0 AND id_user1=' . $userId . ' AND id=' . $model->id_p2)->one();
            if ($row) {
                if ($row->valint1 >= $model->mab) {
                    /* @var $settings \app\modules\site\models\DAL\SiteSettings */
                    $settings = SiteSettingsSRL::get();

                    $payments           = new Payments();
                    $payments->paid     = 0;
                    $payments->id_p1    = $model->id_p2;
                    $payments->id_user1 = $userId;
                    $payments->valint1  = $model->mab;
                    $payments->datetime = functions::getdatetime();
                    $payments->gateway  = $settings->default_gateway;
                    $payments->save();

                    $method      = '';
                    $action      = '';
                    $items       = [];
                    $amount      = $payments->valint1;
                    $description = $settings->title;
                    $callback    = ['/dashboard/default/callback', 'gateway' => $payments->gateway, 'paymentId' => $payments->id];
                    $email       = $user->email;
                    $mobile      = $user->mobile1;
                    //$orderId     = $payments->id;
                    if ($payments->gateway == 3) {
                        $merchant_id = $settings->zarinpal_merchant_id;
                        $method      = 'get';
                        list($isOK, $items, $action) = DARGAH_ZARINPAL::send($merchant_id, $amount, $description, $callback, $email, $mobile);
                        if (!$isOK) {
                            return $this->render('gateway-error');
                        }
                        $payments->zarinpal_authority = ArrayHelper::remove($items, 'Authority');
                        $payments->save();
                    }
                    else {
                        return $this->render('gateway-error');
                    }

                    return $this->render('start-pay', [
                                'method' => $method,
                                'action' => $action,
                                'items'  => $items
                    ]);
                }
                else {
                    $model->addError('mab', Yii::t('coding', 'مبلغ نمی تواند بیشتر از {n} باشد', ['n' => functions::toman($row->valint1)]));
                }
            }
            else {
                $model->addError('id_p2', 'بابت معتبر نمی باشد');
            }
        }

        $row       = functions::queryAll("
            SELECT '1', IFNULL(SUM(mab), 0) AS sum FROM view_hesabha WHERE id_user1 = $userId AND mab > 0
            UNION
            SELECT '2', IFNULL(SUM(mab), 0) AS sum FROM view_hesabha WHERE id_user1 = $userId AND mab < 0
            UNION
            SELECT '3', IFNULL(SUM(m2.bes), 0) AS sum
            FROM tcoding AS m1
            LEFT JOIN hesabha AS m2 ON (m2.id_p1 = m1.id AND m2.id_p2 IS NULL AND m2.id_user1 = m1.id_user1 ) OR (m2.id_p2 = m1.id AND m2.id_p1 = m1.id_p1 AND m2.id_user1 = m1.id_user1)
            WHERE m1.id_noe in(5, 7) AND m1.deleted = 0 AND (m1.id_user3 = $userId OR m1.id_user4 = $userId)
        ");
        $list      = Tcoding::find()->where(['deleted' => 0, 'id_noe' => 5, 'id_user1' => Yii::$app->user->id])->orderBy(['id' => SORT_ASC])->all();
        $rows      = Tcoding::find()->from('view_list_h2 AS m1')->where('m1.valint1 > 0 AND m1.id_user1 = ' . $userId)->all();
        $model->ps = ArrayHelper::map($rows, 'id', 'name1');
        return $this->renderView([
                    'bes'   => str_replace('-', '', "{$row[0]['sum']}"),
                    'bed'   => str_replace('-', '', "{$row[1]['sum']}"),
                    'dar'   => str_replace('-', '', "{$row[2]['sum']}"),
                    'list'  => $list,
                    'model' => $model,
        ]);
    }
    public function actionCallback($gateway, $paymentId) {

        /* @var $settings \app\modules\site\models\DAL\SiteSettings */
        $settings = SiteSettingsSRL::get();
        $id       = null;
        $ref      = null;
        if ($gateway == 3) {
            $zarinpal_authority = Yii::$app->request->get('Authority');
            if ($zarinpal_authority == null) {
                return functions::httpNotFound();
            }

            /* @var $model Payments */
            $model = Payments::findOne([
                'paid'               => 0,
                'id'                 => $paymentId,
                'gateway'            => $gateway,
                'zarinpal_authority' => $zarinpal_authority
            ]);
            if ($model == null) {
                return functions::httpNotFound();
            }

            list($isOK, $items) = DARGAH_ZARINPAL::verify($settings->zarinpal_merchant_id, $model->zarinpal_authority, $model->valint1);
            if (!$isOK) {
                functions::setFailFlash('خطا در پرداخت');
                return $this->redirect(['index']);
            }

            $model->paid            = 1;
            $model->zarinpal_ref_id = $items['RefID'];
            $model->save();

            /* @var $row Tcoding */
            $row = $model->p1;
            if ($row->id_noe == 5) {
                $hesab            = new Hesabha();
                $hesab->id_p1     = $row->id;
                $hesab->id_p2     = null;
                $hesab->id_p3     = null;
                $hesab->id_user1  = $row->id_user1;
                $hesab->id_user2  = $row->id_user3;
                $hesab->bed       = 0;
                $hesab->bes       = $model->valint1;
                $hesab->mab       = $model->valint1;
                $hesab->desc1     = $row->name1;
                $hesab->desc2     = null;
                $hesab->datetime  = functions::getdatetime();
                $hesab->name1     = null;
                $hesab->date1     = null;
                $hesab->save();
                $hesab2           = new Hesabha();
                $hesab2->id_p1    = $row->id;
                $hesab2->id_p2    = null;
                $hesab2->id_p3    = null;
                $hesab2->id_user1 = $row->id_user3;
                $hesab2->id_user2 = $row->id_user1;
                $hesab2->bed      = $model->valint1;
                $hesab2->bes      = 0;
                $hesab2->mab      = $model->valint1;
                $hesab2->desc1    = $row->name1;
                $hesab2->desc2    = null;
                $hesab2->datetime = functions::getdatetime();
                $hesab2->name1    = null;
                $hesab2->date1    = null;
                $hesab2->save();
            }
            else if ($row->id_noe == 7) {
                $hesab            = new Hesabha();
                $hesab->id_p1     = $row->id_p1;
                $hesab->id_p2     = $row->id;
                $hesab->id_p3     = null;
                $hesab->id_user1  = $row->id_user1;
                $hesab->id_user2  = $row->id_user2;
                $hesab->bed       = 0;
                $hesab->bes       = $model->valint1;
                $hesab->mab       = $model->valint1;
                $hesab->desc1     = '';
                $hesab->desc2     = null;
                $hesab->datetime  = functions::getdatetime();
                $hesab->name1     = null;
                $hesab->date1     = null;
                $hesab->save();
                $hesab2           = new Hesabha();
                $hesab2->id_p1    = $row->id_p1;
                $hesab2->id_p2    = $row->id;
                $hesab2->id_p3    = null;
                $hesab2->id_user1 = $row->id_user2;
                $hesab2->id_user2 = $row->id_user1;
                $hesab2->bed      = $model->valint1;
                $hesab2->bes      = 0;
                $hesab2->mab      = $model->valint1;
                $hesab2->desc1    = '';
                $hesab2->desc2    = null;
                $hesab2->datetime = functions::getdatetime();
                $hesab2->name1    = null;
                $hesab2->date1    = null;
                $hesab2->save();
            }

            functions::setSuccessFlash('پرداخت با موفقیت انجام شد');
            return $this->redirect(['index']);
        }
        return functions::httpNotFound();
    }
}