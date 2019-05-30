<?php
use yii\helpers\Html;
use app\assets\LoginAsset;
use app\config\widgets\Alert;
use app\modules\site\models\SRL\SiteSettingsSRL;
/* @var $this \yii\web\View */
/* @var $content string */
LoginAsset::register($this);
$settings = SiteSettingsSRL::get();
$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="icon" type="image/png" href="<?= Yii::getAlias('@web/uploads/settings/favicon/' . $settings->favicon) ?>"/>
        <link rel="shortcut icon" type="image/ico" href="<?= Yii::getAlias('@web/uploads/settings/favicon/' . $settings->favicon) ?>"/>
        <title><?= $settings->title . ' / ' . $this->title ?></title>
        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12" style="margin-bottom: 15px;">
                    <div class="mypanel">
                        <h4><?= $this->title ?></h4>
                        <?= Alert::widget() ?>
                        
<?= $content ?>
                        
                    </div>
                </div>
            </div>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>