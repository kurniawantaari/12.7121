<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "institusi".
 *
 * @property string $kdinstitusi
 * @property string $nminstitusi
 */
class Institusi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'institusi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kdinstitusi', 'nminstitusi'], 'required'],
            [['kdinstitusi', 'nminstitusi'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kdinstitusi' => 'Kdinstitusi',
            'nminstitusi' => 'Nminstitusi',
        ];
    }
}
