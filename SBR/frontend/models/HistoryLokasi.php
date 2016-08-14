<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "history_lokasi".
 *
 * @property integer $idtabel
 * @property string $kddesa
 * @property string $kdkec
 * @property string $kdkab
 * @property string $kdprop
 *
 * @property HistoryTabel $idtabel0
 */
class HistoryLokasi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'history_lokasi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idtabel'], 'integer'],
            [['kddesa', 'kdkec', 'kdkab', 'kdprop'], 'string'],
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
            'kddesa' => 'Kddesa',
            'kdkec' => 'Kdkec',
            'kdkab' => 'Kdkab',
            'kdprop' => 'Kdprop',
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
