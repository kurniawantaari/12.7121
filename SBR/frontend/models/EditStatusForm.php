<?php

namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * AccountDetailFormis the model behind the account detail or profile.
 */
class EditStatusForm extends Model {

    public $id;
    public $status;
    

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
        ['status', 'required'],
        ];
    }

    public function saveStatus() {
        if (!$this->validate()) {
            return null;
        }
        $user = User::findIdentity($this->id);
        $user->status = $this->status;

        return $user->save() ? $user : null;
    }
}
