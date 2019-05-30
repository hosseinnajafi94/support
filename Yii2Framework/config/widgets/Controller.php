<?php
namespace app\config\widgets;
use Yii;
use ReflectionMethod;
use yii\base\InlineAction;
class Controller extends \yii\web\Controller {
    public function createAction($id) {
        if ($id === '') {
            $id = $this->defaultAction;
        }
        $actionMap = $this->actions();
        if (isset($actionMap[$id])) {
            return Yii::createObject($actionMap[$id], [$id, $this]);
        }
        elseif (preg_match('/^[a-z0-9\\-_]+$/', $id) && strpos($id, '--') === false && trim($id, '-') === $id) {
            $methodName = 'action' . str_replace(' ', '', ucwords(str_replace('-', ' ', $id)));
            if (method_exists($this, $methodName)) {
                $method = new ReflectionMethod($this, $methodName);
                if ($method->isPublic() && $method->getName() === $methodName) {
                    return new InlineAction($id, $this, $methodName);
                }
            }
        }
        return null;
    }
    public function beforeAction($action) {
        if (Yii::$app->request->isAjax) {
            $this->layout = false;
        }
        //Yii::$app->response->headers->set('Access-Control-Allow-Origin', '');
        //Yii::$app->response->headers->set('Strict-Transport-Security', 'max-age=60000; includeSubDomains');
        //Yii::$app->response->headers->set('X-Frame-Options', 'deny');
        //Yii::$app->response->headers->set('X-Powered-By', 'Hossein Najafi');
        //Yii::$app->response->headers->set('X-XSS-Protection', '1; mode=block');
        return parent::beforeAction($action);
    }
    public function renderView($params = null) {
        $config = [];
        if ($params === null) {
            $config = [];
        }
        if (is_array($params)) {
            $config = $params;
        }
        else if (is_object($params)) {
            $config = ['model' => $params];
        }
        return parent::render($this->action->id, $config);
    }
    public function redirectToView($params = [], $rep = '&') {
        $params[0] = str_replace(['delete', 'create', 'update', $rep], 'view', $this->action->id);
        return $this->redirect($params);
    }
    public function redirectToIndex($params = [], $rep = '&') {
        $params[0] = str_replace(['delete', 'create', 'update', 'view', $rep], 'index', $this->action->id);
        return $this->redirect($params);
    }
}