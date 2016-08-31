<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "jaringanusaha".
 *
 * @property string $kdjaringanusaha
 * @property string $nmjaringanusaha
 */
class Jaringanusaha extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jaringanusaha';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kdjaringanusaha', 'nmjaringanusaha'], 'required'],
            [['kdjaringanusaha', 'nmjaringanusaha'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kdjaringanusaha' => 'Kdjaringanusaha',
            'nmjaringanusaha' => 'Nmjaringanusaha',
        ];
    }
}
