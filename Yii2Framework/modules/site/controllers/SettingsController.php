<?php
namespace app\modules\site\controllers;
use Yii;
use yii\filters\AccessControl;
use app\config\widgets\Controller;
use app\config\components\functions;
use app\modules\site\models\SRL\SiteSettingsSRL;
use app\modules\users\models\SRL\UsersSRL;
class SettingsController extends Controller {
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                        [
                        'allow'   => true,
                        'actions' => ['index'],
                        'roles'   => ['SiteSettings'],
                        'verbs'   => ['GET', 'POST']
                    ],
                ],
            ],
        ];
    }
    public function actionIndex() {
        $model = SiteSettingsSRL::get();
        if (SiteSettingsSRL::save($model, Yii::$app->request->post())) {
            functions::setSuccessFlash();
            return $this->refresh();
        }
        $model->users = UsersSRL::getItems();
        return $this->renderView($model);
    }
}