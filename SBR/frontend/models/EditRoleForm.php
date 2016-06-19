<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * AccountDetailFormis the model behind the account detail or profile.
 */
class EditRoleForm extends Model {

    public $id;
    public $role;

    public function saveRole() {
        if (!$this->validate()) {
            return null;
        }
        $user = User::findIdentity($this->id);
        $auth = Yii::$app->authManager;
        $auth->assign($this->role, $user->id);
    }

}
