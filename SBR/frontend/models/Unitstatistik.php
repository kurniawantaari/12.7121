<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "unitstatistik".
 *
 * @property string $kdsu
 * @property string $nmsu
 */
class Unitstatistik extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'unitstatistik';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kdsu'], 'required'],
            [['kdsu', 'nmsu'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kdsu' => 'Kdsu',
            'nmsu' => 'Nmsu',
        ];
    }
}
