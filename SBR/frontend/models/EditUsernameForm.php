<?php

namespace frontend\models;

use yii\base\Model;
use common\models\User;


/**
 * AccountDetailFormis the model behind the account detail or profile.
 */
class EditUsernameForm extends Model {

    public $id;
    public $username;
    

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],        
        ];
    }

    public function saveUsername() {
        if (!$this->validate()) {
            return null;
        }
        $user = User::findIdentity($this->id);
        $user->username = $this->username;
        return $user->save() ? $user : null;
    }
}
