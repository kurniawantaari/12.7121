<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * AccountDetailFormis the model behind the account detail or profile.
 */
class EditEmailForm extends Model {

    public $id;
    public $email;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
        ];
    }

    public function saveEmail() {
        if (!$this->validate()) {
            return null;
        }
        $user = User::findIdentity($this->id);
        $user->email = $this->email;
        return $user->save() ? $user : null;
    }

}
