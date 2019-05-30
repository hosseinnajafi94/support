<?php
namespace app\modules\emails\models\SRL;
use app\modules\emails\models\DAL\EmailsSettings;
use app\modules\emails\models\VML\EmailsSettingsVML;
class EmailsSettingsSRL {
    /**
     * @return EmailsSettings
     */
    public static function findModel($id) {
        return EmailsSettings::findOne($id);
    }
    /**
     * @return EmailsSettingsVML
     */
    public static function findViewModel() {
        $model = self::findModel(1);
        if ($model == null) {
            return null;
        }
        $data = new EmailsSettingsVML();
        $data->server = $model->server;
        $data->port = $model->port;
        $data->username = $model->username;
        $data->password = $model->password;
        $data->setModel($model);
        return $data;
    }
    /**
     * @param EmailsSettingsVML $data
     * @return bool
     */
    public static function update($data) {
        if (!$data->validate()) {
            return false;
        }
        $model = $data->getModel();
        $model->server = $data->server;
        $model->port = $data->port;
        $model->username = $data->username;
        $model->password = $data->password;
        return $model->save();
    }
    /**
     * @return EmailsSettings
     */
    public static function get() {
        return self::findModel(1);
    }
}