<?php
namespace app\modules\emails\models\SRL;
use Yii;
use yii\data\ActiveDataProvider;
use app\config\components\functions;
use app\modules\emails\models\DAL\Emails;
use app\modules\emails\models\VML\EmailsVML;
use app\modules\emails\components\Email;
class EmailsSRL {
    /**
     * @return array [EmailsSearchVML $searchModel, ActiveDataProvider $dataProvider]
     */
    public static function searchModel() {
        $query = Emails::find()->orderBy(['id' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
            'pagination' => ['defaultPageSize' => 10]
        ]);
        return $dataProvider;
    }
    /**
     * @return EmailsVML
     */
    public static function newViewModel() {
        $data = new EmailsVML();
        return $data;
    }
    /**
     * @param EmailsVML $data
     * @return bool
     */
    public static function insert($data, $setFlash = true) {
        if (!$data->validate()) {
            return false;
        }
        $settings = EmailsSettingsSRL::get();
        $model = new Emails();
        $model->from_email = $settings->username;
        $model->from_name = Yii::t('emails', 'Support');
        $model->to_email = $data->receiver_email;
        $model->to_name = $data->receiver_name;
        $model->datetime = functions::getdatetime();
        $model->subject = $data->subject;
        $model->message = $data->message;
        $model->theme_id = 1;
        if ($model->save()) {
            $sent = Email::send($settings, $model->from_email, $model->from_name, $model->to_email, $model->to_name, $model->subject, $model->message);
            if ($sent) {
                $data->id = $model->id;
                return true;
            }
            if ($setFlash) {
                functions::setFailFlash(Yii::t('emails', 'Email could not be sent.'));
            }
            $model->delete();
        }
        return false;
    }
    /**
     * @return Emails
     */
    public static function findModel($id) {
        return Emails::findOne($id);
    }
    public static function send($email, $name, $subject, $message) {
        try {
            $data = new EmailsVML();
            $data->receiver_email = $email;
            $data->receiver_name = $name;
            $data->subject = $subject;
            $data->message = $message;
            return self::insert($data, false);
        }
        catch (\Exception $exc) {
            return false;
        }
    }
}