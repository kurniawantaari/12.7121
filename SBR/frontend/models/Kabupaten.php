<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "kabupaten".
 *
 * @property string $kdnegara
 * @property string $kdprop
 * @property string $kdkab
 * @property string $nmkab
 */
class Kabupaten extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kabupaten';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kdnegara', 'kdprop', 'kdkab', 'nmkab'], 'required'],
            [['kdnegara', 'kdprop', 'kdkab', 'nmkab'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kdnegara' => 'Kdnegara',
            'kdprop' => 'Kdprop',
            'kdkab' => 'Kdkab',
            'nmkab' => 'Nmkab',
        ];
    }
}
