<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "history_institusi".
 *
 * @property integer $idtabel
 * @property string $institusi
 *
 * @property HistoryTabel $idtabel0
 */
class HistoryInstitusi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'history_institusi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idtabel'], 'integer'],
            [['institusi'], 'string'],
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
            'institusi' => 'Institusi',
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
