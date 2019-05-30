<?php
namespace app\modules\site\models\SRL;
use yii\web\UploadedFile;
use app\modules\site\models\DAL\SiteSettings;
class SiteSettingsSRL {
    public static function get() {
        return SiteSettings::findOne(1);
    }
    public static function save($model, $params) {
        $oldLogo    = $model->logo;
        $oldFavicon = $model->favicon;
        if (!$model->load($params)) {
            return false;
        }
        self::upload($model, 'logo', $oldLogo);
        self::upload($model, 'favicon', $oldFavicon);
        return $model->save();
    }
    public static function upload($model, $name, $defaultValue = null) {
        $model->$name = UploadedFile::getInstance($model, $name);
        if ($model->$name) {
            $filename   = uniqid(time(), true) . '.' . $model->$name->extension;
            $model->$name->saveAs("uploads/settings/$name/$filename");
            $model->$name = $filename;
        }
        else {
            $model->$name = $defaultValue;
        }
    }
}