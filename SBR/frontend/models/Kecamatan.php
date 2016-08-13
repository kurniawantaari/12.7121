<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "kecamatan".
 *
 * @property string $kdnegara
 * @property string $kdprop
 * @property string $kdkab
 * @property string $kdkec
 * @property string $nmkec
 */
class Kecamatan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kecamatan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kdnegara', 'kdprop', 'kdkab', 'kdkec', 'nmkec'], 'required'],
            [['kdnegara', 'kdprop', 'kdkab', 'kdkec', 'nmkec'], 'string'],
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
            'kdkec' => 'Kdkec',
            'nmkec' => 'Nmkec',
        ];
    }
}
