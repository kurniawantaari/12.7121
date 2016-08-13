<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "desa".
 *
 * @property string $kdnegara
 * @property string $kdprop
 * @property string $kdkab
 * @property string $kdkec
 * @property string $kddesa
 * @property string $nmdesa
 * @property string $klasifikasi
 */
class Desa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'desa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kdnegara', 'kdprop', 'kdkab', 'kdkec', 'kddesa', 'nmdesa'], 'required'],
            [['kdnegara', 'kdprop', 'kdkab', 'kdkec', 'kddesa', 'nmdesa', 'klasifikasi'], 'string'],
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
            'kddesa' => 'Kddesa',
            'nmdesa' => 'Nmdesa',
            'klasifikasi' => 'Klasifikasi',
        ];
    }
}
