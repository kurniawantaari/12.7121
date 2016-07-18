<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

class RoleForm extends Model {

    public $roleList;
    public $_user;

    public function __construct($username, $config = []) {
        if (empty($username) || !is_string($token)) {
            throw new InvalidParamException('Username cannot be blank.');
        }
        $this->_user = User::findByUsername($username);
        $auth = Yii::$app->authManager;
        $this->roleList = $auth->getRolesByUser($this->_user->id);
        if (!$this->_user) {
            throw new InvalidParamException('Wrong username.');
        }
        parent::__construct($config);
    }

    public function changeRole() {
        $auth = Yii::$app->authManager;
        foreach ($this->roles as $role) {
            $asrole = $auth->getRole($role);
            $auth->assign($role, $this->id);

            if (!$asrole) {
                throw new InvalidParamException("There is no role \"$role\".");
            }

            $auth->assign($asrole, $user->id);
        }
    }

    public function deleteRole($role, $username) {
        $user = User::findOne(['username' => $username]);
        if (!$user) {
            throw new InvalidParamException("There is no user \"$username\".");
        }

        $auth = Yii::$app->authManager;
        $asrole = $auth->getRole($role);
        if (!$asrole) {
            throw new InvalidParamException("There is no role \"$role\".");
        }

        
    }

}
