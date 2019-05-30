<?php
namespace app\config\widgets;
use Yii;
use yii\helpers\Html;
class Breadcrumbs extends \yii\widgets\Breadcrumbs {
    public $encodeLabels = false;
    public function run() {
        $links = [];
        $links[] = $this->renderItem(['label' => Yii::t('yii', 'داشبورد'), 'url' => ['/dashboard/default/index']], $this->itemTemplate);
        foreach ($this->links as $link) {
            if (!is_array($link)) {
                $link = ['label' => $link];
            }
            $links[] = $this->renderItem($link, isset($link['url']) ? $this->itemTemplate : $this->activeItemTemplate);
        }
        echo Html::tag($this->tag, implode('', $links), $this->options);
    }
}