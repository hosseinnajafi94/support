<?php
namespace app\modules\users\controllers;
use Yii;
use yii\filters\AccessControl;
use app\config\widgets\Controller;
use app\config\components\functions;
use app\modules\users\models\SRL\UsersSRL;
class UsersController extends Controller {
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                        [
                        'allow'   => true,
                        'actions' => ['index', 'view', 'role'],
                        'roles'   => ['Users'],
                        'verbs'   => ['GET']
                    ],
                        [
                        'allow'   => true,
                        'actions' => ['delete', 'reset-password'],
                        'roles'   => ['Users'],
                        'verbs'   => ['POST']
                    ],
                        [
                        'allow'   => true,
                        'actions' => ['create', 'update'],
                        'roles'   => ['Users'],
                        'verbs'   => ['GET', 'POST']
                    ],
                ],
            ],
        ];
    }
    public function actionIndex() {
        $model = UsersSRL::searchModel();
        return $this->renderView($model);
    }
    public function actionView($id) {
        $model = UsersSRL::findModel($id);
        if ($model == null) {
            functions::httpNotFound();
        }
        return $this->renderView($model);
    }
    public function actionCreate() {
        $model = UsersSRL::newViewModel('create');
        if ($model->load(Yii::$app->request->post()) && UsersSRL::insert($model)) {
            functions::setSuccessFlash();
            return $this->redirectToView(['id' => $model->id]);
        }
        UsersSRL::loadItems($model);
        return $this->renderView($model);
    }
    public function actionUpdate($id) {
        $model = UsersSRL::findViewModel($id, 'update');
        if ($model == null) {
            functions::httpNotFound();
        }
        if ($model->load(Yii::$app->request->post()) && UsersSRL::update($model)) {
            functions::setSuccessFlash();
            return $this->redirectToView(['id' => $model->id]);
        }
        UsersSRL::loadItems($model);
        return $this->renderView($model);
    }
    public function actionDelete($id) {
        $deleted = UsersSRL::delete($id);
        if ($deleted) {
            functions::setSuccessFlash();
        }
        else {
            functions::setFailFlash();
        }
        return $this->redirectToIndex();
    }
    public function actionResetPassword($id) {
        $reset = UsersSRL::resetPasswordUser($id);
        if ($reset) {
            functions::setSuccessFlash();
        }
        else {
            functions::setFailFlash();
        }
        return $this->redirectToView(['id' => $id], 'reset-password');
    }
    public function actionRole() {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $tcodingRule = new \app\modules\users\components\TcodingRule();
        $auth->add($tcodingRule);
        
        $i = 0;
        
        $tcoding              = $auth->createPermission('Tcoding');
        $tcoding->description = ($i++) . '- اطلاعات پایه';
        $auth->add($tcoding);

        $dashboard              = $auth->createPermission('Dashboard');
        $dashboard->description = ($i++) . '- داشبورد';
        $auth->add($dashboard);

        $profile              = $auth->createPermission('Profile');
        $profile->description = ($i++) . '- پروفایل';
        $auth->add($profile);

        $ticketing              = $auth->createPermission('Ticketing');
        $ticketing->description = ($i++) . '- تیکت ها';
        $auth->add($ticketing);

        $usersGroups              = $auth->createPermission('UsersGroups');
        $usersGroups->description = ($i++) . '- گروه کاربری';
        $auth->add($usersGroups);

        $users              = $auth->createPermission('Users');
        $users->description = ($i++) . '- کاربران';
        $auth->add($users);

        $VahedKala              = $auth->createPermission('VahedKala');
        $VahedKala->description = ($i++) . '- واحد کالا';
        $VahedKala->ruleName    = $tcodingRule->name;
        $auth->add($VahedKala);
        $auth->addChild($VahedKala, $tcoding);

        $Kala              = $auth->createPermission('Kala');
        $Kala->description = ($i++) . '- کالاها';
        $Kala->ruleName    = $tcodingRule->name;
        $auth->add($Kala);
        $auth->addChild($Kala, $tcoding);

        $Discount              = $auth->createPermission('Discount');
        $Discount->description = ($i++) . '- تخفیفات';
        $Discount->ruleName    = $tcodingRule->name;
        $auth->add($Discount);
        $auth->addChild($Discount, $tcoding);

        $Sale              = $auth->createPermission('Sale');
        $Sale->description = ($i++) . '- فروش';
        $Sale->ruleName    = $tcodingRule->name;
        $auth->add($Sale);
        $auth->addChild($Sale, $tcoding);

        $NoeBedehkari              = $auth->createPermission('NoeBedehkari');
        $NoeBedehkari->description = ($i++) . '- انواع بدهکاری';
        $NoeBedehkari->ruleName    = $tcodingRule->name;
        $auth->add($NoeBedehkari);
        $auth->addChild($NoeBedehkari, $tcoding);

        $Bedehkari              = $auth->createPermission('Bedehkari');
        $Bedehkari->description = ($i++) . '- بدهکاری ها';
        $Bedehkari->ruleName    = $tcodingRule->name;
        $auth->add($Bedehkari);
        $auth->addChild($Bedehkari, $tcoding);

        $NoeDaryaftPardakht              = $auth->createPermission('NoeDaryaftPardakht');
        $NoeDaryaftPardakht->description = ($i++) . '- نوع دریافت - پرداخت';
        $NoeDaryaftPardakht->ruleName    = $tcodingRule->name;
        $auth->add($NoeDaryaftPardakht);
        $auth->addChild($NoeDaryaftPardakht, $tcoding);

        $Hesabha              = $auth->createPermission('Hesabha');
        $Hesabha->description = ($i++) . '- حساب ها';
        $auth->add($Hesabha);

        $sms              = $auth->createPermission('Sms');
        $sms->description = ($i++) . '- پیامک ها';
        $auth->add($sms);

        $smsSettings              = $auth->createPermission('SmsSettings');
        $smsSettings->description = ($i++) . '- تنظیمات پیامک';
        $auth->add($smsSettings);

        $email              = $auth->createPermission('Email');
        $email->description = ($i++) . '- ایمیل ها';
        $auth->add($email);

        $emailSettings              = $auth->createPermission('EmailSettings');
        $emailSettings->description = ($i++) . '- تنظیمات ایمیل';
        $auth->add($emailSettings);

        $siteSettings              = $auth->createPermission('SiteSettings');
        $siteSettings->description = ($i++) . '- تنظیمات سایت';
        $auth->add($siteSettings);

        $auth->assign($dashboard, 1);
        $auth->assign($profile, 1);
        $auth->assign($ticketing, 1);
        $auth->assign($usersGroups, 1);
        $auth->assign($users, 1);
        $auth->assign($VahedKala, 1);
        $auth->assign($Kala, 1);
        $auth->assign($Discount, 1);
        $auth->assign($Sale, 1);
        $auth->assign($NoeBedehkari, 1);
        $auth->assign($Bedehkari, 1);
        $auth->assign($NoeDaryaftPardakht, 1);
        $auth->assign($Hesabha, 1);
        $auth->assign($sms, 1);
        $auth->assign($smsSettings, 1);
        $auth->assign($email, 1);
        $auth->assign($emailSettings, 1);
        $auth->assign($siteSettings, 1);
    }
}