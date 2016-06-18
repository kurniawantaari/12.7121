<?php

namespace frontend\models;

use yii\base\Model;
use yii\base\InvalidParamException;
use common\models\User;

/**
 * Account Activation form
 */
class AccountActivationForm extends Model {

        /**
     * @var \common\models\User
     */
    private $_user;

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
 public function rules()
    {
        return [
          
        ];
    }
    /**
     * Activate account.
     *
     * @return boolean if account was activate.
     */
    public function activateAccount() {
        $user = $this->_user;
        $user->status=10;
        $user->removeAccountActivationToken();
        return $user->save(false);
    }

}
