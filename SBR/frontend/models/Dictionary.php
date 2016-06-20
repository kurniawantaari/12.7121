<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "dictionary".
 *
 * @property integer $id
 * @property string $term
 * @property string $description
 */
class Dictionary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dictionary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['term', 'description'], 'required'],
            [['term', 'description'], 'string'],
            [['term'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'term' => 'Term',
            'description' => 'Description',
        ];
    }
}
