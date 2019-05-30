<?php
namespace app\modules\sms\models\SRL;
use app\modules\sms\models\DAL\SmsSettings;
use app\modules\sms\models\VML\SmsSettingsVML;
class SmsSettingsSRL {
    /**
     * @return SmsSettings
     */
    public static function findModel($id) {
        return SmsSettings::findOne($id);
    }
    /**
     * @return SmsSettingsVML
     */
    public static function findViewModel() {
        $model = self::findModel(1);
        if ($model == null) {
            return null;
        }
        $data = new SmsSettingsVML();
        $data->id = $model->id;
        $data->address = $model->address;
        $data->username = $model->username;
        $data->password = $model->password;
        $data->line_number = $model->line_number;
        $data->setModel($model);
        return $data;
    }
    /**
     * @param SmsSettingsVML $data
     * @return bool
     */
    public static function update($data) {
        if (!$data->validate()) {
            return false;
        }
        $model = $data->getModel();
        $model->address = $data->address;
        $model->username = $data->username;
        $model->password = $data->password;
        $model->line_number = $data->line_number;
        return $model->save();
    }
    /**
     * @return SmsSettings
     */
    public static function get() {
        return self::findModel(1);
    }
}