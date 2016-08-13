<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tahun".
 *
 * @property integer $id
 * @property string $tahun
 * @property string $jenis
 */
class Tahun extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tahun';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'jenis'], 'required'],
            [['tahun', 'jenis'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tahun' => 'Tahun',
            'jenis' => 'Jenis',
        ];
    }
}
