<?php
namespace app\modules\users\components;
use Yii;
class TcodingRule extends \yii\rbac\Rule {
    public $name = 'TcodingRule';
    /**
     * @param string|int $user the user ID.
     * @param \yii\rbac\Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params) {
        $module = Yii::$app->getModule('coding');
        return isset($params['idnoe']) && (
               ($params['idnoe'] == $module->params['VahedKala']         && $item->name == 'VahedKala')
            || ($params['idnoe'] == $module->params['Kala']              && $item->name == 'Kala')
            || ($params['idnoe'] == $module->params['Discount']          && $item->name == 'Discount')
            || ($params['idnoe'] == $module->params['Sale']              && $item->name == 'Sale')
            || ($params['idnoe'] == $module->params['NoeBedehkari']      && $item->name == 'NoeBedehkari')
            || ($params['idnoe'] == $module->params['Bedehkari']         && $item->name == 'Bedehkari')
            || ($params['idnoe'] == $module->params['NoeDaryaftPardakht']&& $item->name == 'NoeDaryaftPardakht')
//            || ($params['idnoe'] == 9)
//            || ($params['idnoe'] == 10)
//            || ($params['idnoe'] == 11)
        );
    }
}