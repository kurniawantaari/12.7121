<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;
use common\models\User;
/**
 * AccountDetailFormis the model behind the account detail or profile.
 */
class EditRoleForm extends Model {

  public $roles = Array();
    public $activeRoles = Array();

        private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($id, $config = [])
    {
        if (empty($id) || !is_string($id)) {
            throw new InvalidParamException('User id cannot be blank.');
        }
        $this->_user = User::findIdentity($id);
        if (!$this->_user) {
            throw new InvalidParamException('Wrong id token.');
        }
        parent::__construct($config);
    }
    public function changeRole() {
        $auth = Yii::$app->authManager;
        $this->activeRoles = $auth->getRolesByUser($this->_user->id);
        foreach ($this->activeRoles as $role) {
            $auth->revoke($role, $this->_user->id);
            $auth->assign($role, $this->_user->id);
        }
    }

}
