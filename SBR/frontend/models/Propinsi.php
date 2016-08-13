<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "propinsi".
 *
 * @property string $kdnegara
 * @property string $kdprop
 * @property string $nmprop
 */
class Propinsi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'propinsi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kdnegara', 'kdprop', 'nmprop'], 'required'],
            [['kdnegara', 'kdprop', 'nmprop'], 'string'],
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
            'nmprop' => 'Nmprop',
        ];
    }
}
