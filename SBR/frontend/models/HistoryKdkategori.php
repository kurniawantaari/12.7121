<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "history_kdkategori".
 *
 * @property integer $idtabel
 * @property string $kdkategori
 *
 * @property HistoryTabel $idtabel0
 */
class HistoryKdkategori extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'history_kdkategori';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idtabel'], 'integer'],
            [['kdkategori'], 'string'],
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
            'kdkategori' => 'Kdkategori',
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
