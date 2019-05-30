<?php
namespace app\modules\sms\models\SRL;
use Yii;
use app\modules\SRL;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use app\config\components\functions;
use app\modules\sms\models\DAL\Sms;
use app\modules\sms\models\VML\SmsVML;
use app\modules\sms\components\SmsIR;
use app\modules\users\models\SRL\UsersSRL;
class SmsSRL implements SRL {
    /**
     * @return array [SmsSearchVML $searchModel, ActiveDataProvider $dataProvider]
     */
    public static function searchModel() {
        $query        = Sms::find()->orderBy(['id' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'sort'       => false,
            'pagination' => ['defaultPageSize' => 10]
        ]);
        return $dataProvider;
    }
    /**
     * @return SmsVML
     */
    public static function newViewModel() {
        $data = new SmsVML();
        return $data;
    }
    /**
     * @return SmsVML
     */
    public static function newViewModelUser($id) {
        if (!is_numeric($id)) {
            return null;
        }
        $user = UsersSRL::findModelActiveUser($id);
        if ($user == null) {
            return null;
        }
        $data              = new SmsVML();
        $data->receiver_id = $user->id;
        return $data;
    }
    /**
     * @param SmsVML $data
     * @return void
     */
    public static function loadItems($data) {
        
    }
    /**
     * @param SmsVML $data
     * @return bool
     */
    public static function insert($data) {
        if (!$data->validate()) {
            return false;
        }
        $settings           = SmsSettingsSRL::get();
        $model              = new Sms();
        $model->from_number = $settings->line_number;
        $model->to_number   = $data->receiver;
        $model->message     = $data->message;
        $model->datetime    = functions::getdatetime();
        if ($model->save()) {
            $sent = SmsIR::send($settings, $model->to_number, $model->message);
            if ($sent) {
                $data->id = $model->id;
                return true;
            }
            functions::setFailFlash(Yii::t('sms', 'Sms could not be sent.'));
            $model->delete();
        }
        return false;
    }
    /**
     * @return Sms     */
    public static function findModel($id) {
        return Sms::findOne($id);
    }
    /**
     * @param int $id
     * @return SmsVML
     */
    public static function findViewModel($id) {
        $model = self::findModel($id);
        if ($model == null) {
            return null;
        }
        $data              = new SmsVML();
        $data->id          = $model->id;
        $data->from_number = $model->from_number;
        $data->to_number   = $model->to_number;
        $data->message     = $model->message;
        $data->datetime    = $model->datetime;
        $data->setModel($model);
        return $data;
    }
    /**
     * @param SmsVML $data
     * @return bool
     */
    public static function update($data) {
        if (!$data->validate()) {
            return false;
        }
        $model              = $data->getModel();
        $model->from_number = $data->from_number;
        $model->to_number   = $data->to_number;
        $model->message     = $data->message;
        $model->datetime    = $data->datetime;
        return $model->save();
    }
    /**
     * @param int $id
     * @return bool
     */
    public static function delete($id) {
        $model = self::findModel($id);
        if ($model == null) {
            return false;
        }
        return $model->delete() ? true : false;
    }
    /**
     * @return Sms[]
     */
    public static function getModels() {
        return Sms::find()->orderBy(['id' => SORT_ASC])->all();
    }
    /**
     * @return array
     */
    public static function getItems() {
        $models = self::getModels();
        return ArrayHelper::map($models, 'id', 'id');
    }
    /**
     * @param string $mobile
     * @param string $message
     * @return bool
     */
    public static function send($mobile, $message) {
        try {
            $settings           = SmsSettingsSRL::get();
            $model              = new Sms();
            $model->from_number = $settings->line_number;
            $model->to_number   = $mobile;
            $model->message     = $message;
            $model->datetime    = functions::getdatetime();
            if ($model->save()) {
                $sent = SmsIR::send($settings, $mobile, $message);
                if ($sent) {
                    return true;
                }
                $model->delete();
            }
            return false;
        }
        catch (\Exception $exc) {
            return false;
        }
    }
}