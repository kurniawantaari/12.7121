<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "kategori".
 *
 * @property string $kdkategori
 * @property string $nmkategori
 * @property string $tahun
 */
class Kategori extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kategori';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kdkategori', 'nmkategori', 'tahun'], 'required'],
            [['kdkategori', 'nmkategori', 'tahun'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kdkategori' => 'Kdkategori',
            'nmkategori' => 'Nmkategori',
            'tahun' => 'Tahun',
        ];
    }
}
