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
    private $_user;
    
public function __construct($id, $config = [])
    {
        if (empty($id)) {
            throw new InvalidParamException('User id cannot be blank.');
        }
        $this->_user = User::findIdentity($id);
        if (!$this->_user) {
            throw new InvalidParamException('There is no such user id.');
        }
        parent::__construct($config);
    }
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
       $user = $this->_user;
        $user->username = $this->username;
        return $user->save() ? $user : null;
    }
}
