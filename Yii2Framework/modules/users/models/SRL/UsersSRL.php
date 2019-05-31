<?php
namespace app\modules\users\models\SRL;
use Yii;
use yii\data\ActiveDataProvider;
use app\modules\users\models\DAL\Users;
use app\modules\users\models\VML\UsersVML;
use app\config\components\functions;
use app\config\widgets\ArrayHelper;
class UsersSRL {
    /**
     * @return ActiveDataProvider
     */
    public static function searchModel() {
        $module       = Yii::$app->getModule('users');
        $query        = Users::find()->where(['status_id' => $module->params['status.Active']])->orderBy(['id' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'sort'       => false,
            'pagination' => ['defaultPageSize' => 10]
        ]);
        return $dataProvider;
    }
    /**
     * @return UsersVML
     */
    public static function newViewModel($scenario) {
        $data           = new UsersVML();
        $data->scenario = $scenario;
        $data->roles    = ['Dashboard', 'Profile', 'Ticketing'];
        return $data;
    }
    /**
     * @param UsersVML $data
     * @return void
     */
    public static function loadItems($data) {
        $data->_groups = UsersGroupsSRL::getItems();
        $data->_refs   = self::getItems();
        $roleItems     = Users::find()->select('name as fname, description as lname')->from('auth_item')->where("name not in ('Reservation', 'Tcoding')")->orderBy('CAST(description AS UNSIGNED) ASC')->all();
        $data->_roles  = ArrayHelper::map($roleItems, 'fname', 'lname');
    }
    /**
     * @param UsersVML $data
     * @return bool
     */
    public static function insert($data, $postParams = []) {
        if (!$data->load($postParams) || !$data->validate()) {
            return false;
        }
        $userId                      = Yii::$app->user->id;
        $datetime                    = functions::getdatetime();
        $module                      = Yii::$app->getModule('users');
        $model                       = new Users();
        $model->status_id            = $module->params['status.Active'];
        $model->group_id             = $data->group_id;
        $model->ref_id               = $data->ref_id;
        $model->can_login            = $data->can_login;
        $model->username             = $data->username;
        $model->password_hash        = Yii::$app->security->generatePasswordHash($module->params['defaultPassword']);
        $model->fname                = $data->fname;
        $model->lname                = $data->lname;
        $model->email                = $data->email;
        $model->mobile1              = $data->mobile1;
        $model->mobile2              = $data->mobile2;
        $model->phone1               = $data->phone1;
        $model->phone2               = $data->phone2;
        $model->address              = $data->address;
        $model->avatar               = $module->params['defaultAvatar'];
        $model->auth_key             = Yii::$app->security->generateRandomString();
        $model->password_reset_token = null;
        $model->created_at           = $datetime;
        $model->created_by           = $userId;
        $model->updated_at           = $datetime;
        $model->updated_by           = $userId;
        if ($model->save()) {
            $data->id = $model->id;
            self::assignRoleToUser($data);
            return true;
        }
        $data->addErrors($model->getErrors());
        return false;
    }
    /**
     * @param int $id User ID
     * @return Users
     */
    public static function findModel($id) {
        $module = Yii::$app->getModule('users');
        return self::findUser(['id' => $id, 'status_id' => $module->params['status.Active']]);
    }
    /**
     * @param array|int $id Integer User ID | Array Conditions
     * @return Users
     */
    public static function findUser($id) {
        return Users::findOne($id);
    }
    /**
     * @param int $id
     * @return UsersVML
     */
    public static function findViewModel($id, $scenario) {
        $model = self::findModel($id);
        if ($model == null) {
            return null;
        }
        $data            = new UsersVML();
        $data->scenario  = $scenario;
        $data->id        = $model->id;
        $data->can_login = $model->can_login;
        $data->username  = $model->username;
        $data->fname     = $model->fname;
        $data->lname     = $model->lname;
        $data->email     = $model->email;
        $data->mobile1   = $model->mobile1;
        $data->mobile2   = $model->mobile2;
        $data->phone1    = $model->phone1;
        $data->phone2    = $model->phone2;
        $data->address   = $model->address;
        if ($data->scenario == 'update') {
            $data->group_id = $model->group_id;
            $data->ref_id   = $model->ref_id;
            $data->email    = $model->email;
            $data->mobile1  = $model->mobile1;
            $data->mobile2  = $model->mobile2;
            $data->phone1   = $model->phone1;
            $data->phone2   = $model->phone2;
            $data->address  = $model->address;
            $auth           = Yii::$app->authManager;
            $permissions    = $auth->getPermissionsByUser($data->id);
            foreach ($permissions as $name => $permission) {
                $data->roles[] = $name;
            }
        }
        $data->model = $model;
        return $data;
    }
    /**
     * @param UsersVML $data
     * @return bool
     */
    public static function update($data, $postParams = []) {
        if (!$data->load($postParams) || !$data->validate()) {
            return false;
        }
        $model             = $data->model;
        $model->updated_at = functions::getdatetime();
        $model->updated_by = Yii::$app->user->id;
        if ($data->scenario == 'change-password') {
            $isValid = Yii::$app->security->validatePassword($data->old_password, $model->password_hash);
            if (!$isValid) {
                $data->addError('old_password', Yii::t('users', 'The old password is wrong!'));
                return false;
            }
            if ($data->new_password != $data->new_password_repeat) {
                $data->addError('new_password_repeat', Yii::t('users', 'New password is not equal to repetition.'));
                return false;
            }
            $model->password_hash = Yii::$app->security->generatePasswordHash($data->new_password);
            if ($model->save()) {
                return true;
            }
            $data->addErrors($model->getErrors());
            return false;
        }
        else if ($data->scenario == 'update-profile') {
            $model->username = $data->username;
            $model->fname    = $data->fname;
            $model->lname    = $data->lname;
            $model->email    = $data->email;
            $model->mobile1  = $data->mobile1;
            $model->mobile2  = $data->mobile2;
            $model->phone1   = $data->phone1;
            $model->phone2   = $data->phone2;
            $model->address  = $data->address;
            if ($model->save()) {
                return true;
            }
            $data->addErrors($model->getErrors());
            return false;
        }
        else if ($data->scenario == 'update') {
            $model->group_id  = $data->group_id;
            $model->ref_id    = $data->ref_id;
            $model->can_login = $data->can_login;
            $model->username  = $data->username;
            $model->fname     = $data->fname;
            $model->lname     = $data->lname;
            $model->email     = $data->email;
            $model->mobile1   = $data->mobile1;
            $model->mobile2   = $data->mobile2;
            $model->phone1    = $data->phone1;
            $model->phone2    = $data->phone2;
            $model->address   = $data->address;
            if ($model->save()) {
                self::assignRoleToUser($data);
                return true;
            }
            $data->addErrors($model->getErrors());
            return false;
        }
        return false;
    }
    /**
     * @param int $id
     * @return bool
     */
    public static function delete($id) {
        $model = self::findModel($id);
        if ($model == null) {
            return false;
        }
        $module            = Yii::$app->getModule('users');
        $model->status_id  = $module->params['status.Delete'];
        $model->updated_at = functions::getdatetime();
        $model->updated_by = Yii::$app->user->id;
        return $model->save();
    }
    /**
     * @param int $id
     * @return bool
     */
    public static function resetPasswordUser($id) {
        $model = self::findModel($id);
        if ($model == null) {
            return false;
        }
        $module               = Yii::$app->getModule('users');
        $model->password_hash = Yii::$app->security->generatePasswordHash($module->params['defaultPassword']);
        $model->updated_at    = functions::getdatetime();
        $model->updated_by    = Yii::$app->user->id;
        return $model->save();
    }
    /**
     * @param UsersVML $user User View Model
     * @return void
     */
    public static function assignRoleToUser($user) {
        $auth = Yii::$app->authManager;
        $auth->revokeAll($user->id);
        if (is_array($user->roles)) {
            foreach ($user->roles as $role) {
                $auth->assign($auth->getPermission($role), $user->id);
            }
        }
    }
    /**
     * 
     */
    public static function getItems($group_id = null) {
        $query = Users::find()->where(['status_id' => 1]);
        if ($group_id) {
            $query->andWhere(['group_id' => $group_id]);
        }
        $models = $query->orderBy(['lname' => SORT_ASC, 'fname' => SORT_ASC])->all();
        return ArrayHelper::map($models, 'id', function ($model) {
            return "# $model->id / $model->fname $model->lname";
        });
    }
}