<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "statusperusahaan".
 *
 * @property string $kdkondisi
 * @property string $nmkondisi
 */
class Statusperusahaan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'statusperusahaan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kdkondisi', 'nmkondisi'], 'required'],
            [['kdkondisi', 'nmkondisi'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kdkondisi' => 'Kdkondisi',
            'nmkondisi' => 'Nmkondisi',
        ];
    }
}
