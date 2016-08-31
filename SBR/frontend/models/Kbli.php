<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "kbli".
 *
 * @property string $kdkategori
 * @property string $kdkbli
 * @property string $nmkbli
 * @property string $tahun
 */
class Kbli extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kbli';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kdkategori', 'tahun'], 'required'],
            [['kdkategori', 'kdkbli', 'nmkbli', 'tahun'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kdkategori' => 'Kdkategori',
            'kdkbli' => 'Kdkbli',
            'nmkbli' => 'Nmkbli',
            'tahun' => 'Tahun',
        ];
    }
}
