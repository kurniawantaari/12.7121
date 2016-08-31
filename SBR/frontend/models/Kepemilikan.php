<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "kepemilikan".
 *
 * @property string $kdkepemilikan
 * @property string $nmkepemilikan
 */
class Kepemilikan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kepemilikan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kdkepemilikan', 'nmkepemilikan'], 'required'],
            [['kdkepemilikan', 'nmkepemilikan'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kdkepemilikan' => 'Kdkepemilikan',
            'nmkepemilikan' => 'Nmkepemilikan',
        ];
    }
}
