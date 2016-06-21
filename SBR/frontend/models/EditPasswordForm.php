<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;
use common\models\User;

/**
 * AccountDetailFormis the model behind the account detail or profile.
 */
class EditPasswordForm extends Model {

    public $oldPassword;
    public $newPassword;
    public $confirmNewPassword;
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($id, $config = []) {
        if (empty($id) || !is_string($id)) {
            throw new InvalidParamException('User id cannot be blank.');
        }
        $this->_user = User::findIdentity($id);
        if (!$this->_user) {
            throw new InvalidParamException('Wrong id token.');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['oldPassword', 'required'],
            ['oldPassword', 'string', 'min' => 6],
            ['newPassword', 'required'],
            ['newPassword', 'string', 'min' => 6],
            ['confirmNewPassword', 'required'],
            ['confirmNewPassword', 'string', 'min' => 6],
            ['confirmNewPassword', 'compare', 'compareAttribute' => 'newPassword'],
        ];
    }

    public function saveNewPassword() {
        if (!$this->validate()) {
            return null;
        }
        if ($this->_user->validatePassword($this->oldPassword)) {
            $this->_user->setPassword($this->newPassword);
            return $this->_user->save();
        }
    }

}
