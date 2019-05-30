<?php
namespace app\config\widgets;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
class Nav extends \yii\bootstrap\Nav {
    public $dropDownCaret = '<span class="fa arrow"></span>';
    public $dropdownClass = 'app\config\widgets\Dropdown';
    public function renderItem($item) {
        if (is_string($item)) {
            return $item;
        }
        if (!isset($item['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }
        $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
        $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
        $options = ArrayHelper::getValue($item, 'options', []);
        $items = ArrayHelper::getValue($item, 'items');
        $url = ArrayHelper::getValue($item, 'url', '#');
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
        if (isset($item['active'])) {
            $active = ArrayHelper::remove($item, 'active', false);
        }
        else {
            $active = $this->isItemActive($item);
        }
        if (empty($items)) {
            $items = '';
        }
        else {
            if ($this->dropDownCaret !== '') {
                $label .= ' ' . $this->dropDownCaret;
            }
            if (is_array($items)) {
                $items = $this->isChildActive($items, $active);
                $items = $this->renderDropdown($items, $item);
            }
        }
        if ($active) {
            Html::addCssClass($options, 'active');
        }
        return Html::tag('li', Html::a($label, $url, $linkOptions) . $items, $options);
    }
}