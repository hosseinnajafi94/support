<?php
namespace app\config\widgets;
use yii\bootstrap\Html;
class Dropdown extends \yii\bootstrap\Dropdown {
    public function init() {
        if ($this->submenuOptions === null) {
            $this->submenuOptions = $this->options;
            unset($this->submenuOptions['id']);
        }
        parent::init();
        Html::removeCssClass($this->options, ['widget' => 'dropdown-menu']);
    }
}