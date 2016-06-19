<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * AccountDetailFormis the model behind the account detail or profile.
 */
class EditPasswordForm extends Model {

    public $id;
    public $password;
    public $newPassword;
    public $confirmNewPassword;
      /**
     * @inheritdoc
     */
    public function rules() {
        return [
             ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['newPassword', 'string', 'min' => 6],
            ['confirmNewPassword', 'string', 'min' => 6],
        ];
    }

      public function savePassword() {
        if (!$this->validate()) {
            return null;
        }
        $user = User::findIdentity($this->id);
        $user->setPassword($this->password);
        return $user->save() ? $user : null;
    }
  }
