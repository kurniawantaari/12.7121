<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "history_kepemilikan".
 *
 * @property integer $idtabel
 * @property string $kepemilikan
 *
 * @property HistoryTabel $idtabel0
 */
class HistoryKepemilikan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'history_kepemilikan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idtabel'], 'integer'],
            [['kepemilikan'], 'string'],
            [['idtabel'], 'exist', 'skipOnError' => true, 'targetClass' => HistoryTabel::className(), 'targetAttribute' => ['idtabel' => 'idtabel']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idtabel' => 'Idtabel',
            'kepemilikan' => 'Kepemilikan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdtabel0()
    {
        return $this->hasOne(HistoryTabel::className(), ['idtabel' => 'idtabel']);
    }
}
