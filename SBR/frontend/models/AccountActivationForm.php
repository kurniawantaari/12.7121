<?php

namespace frontend\models;

use yii\base\Model;
use yii\base\InvalidParamException;
use common\models\User;

/**
 * Password reset form
 */
class AccountActivationForm extends Model {

    public $activate;

    /**
     * @var \common\models\User
     */
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = []) {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Account activation token cannot be blank.');
        }
        $this->_user = User::findByAccountActivationToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Wrong account activation token.');
        }
        parent::__construct($config);
    }

    /**
     * Activate account.
     *
     * @return boolean if account was activate.
     */
    public function activateAccount() {
        $user = $this->_user;
        //$user->email = $this->email; change status
        //return $user->save() ? $user : null;
        
        $user->removeAccountActivation();
        return $user->save(false);
    }

}
