<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "history_unitstatistik".
 *
 * @property integer $idtabel
 * @property string $unitstatistik
 *
 * @property HistoryTabel $idtabel0
 */
class HistoryUnitstatistik extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'history_unitstatistik';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idtabel'], 'integer'],
            [['unitstatistik'], 'string'],
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
            'unitstatistik' => 'Unitstatistik',
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
