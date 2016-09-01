<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "history_attributes".
 *
 * @property integer $idtabel
 * @property integer $jumlahmasuk
 * @property integer $jumlahkeluar
 * @property integer $jumlahunit0
 * @property integer $beroperasi
 * @property integer $jumlahunit1
 * @property integer $perubahan
 * @property integer $survived1
 * @property integer $survived2
 * @property integer $survived3
 * @property integer $survivalrate1
 * @property integer $survivalrate2
 * @property integer $survivalrate3
 * @property integer $jumlahunit
 *
 * @property HistoryTabel $idtabel0
 */
class HistoryAttributes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'history_attributes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idtabel', 'jumlahmasuk', 'jumlahkeluar', 'jumlahunit0', 'beroperasi', 'jumlahunit1', 'perubahan', 'survived1', 'survived2', 'survived3', 'survivalrate1', 'survivalrate2', 'survivalrate3', 'jumlahunit'], 'integer'],
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
            'jumlahmasuk' => 'Jumlahmasuk',
            'jumlahkeluar' => 'Jumlahkeluar',
            'jumlahunit0' => 'Jumlahunit0',
            'beroperasi' => 'Beroperasi',
            'jumlahunit1' => 'Jumlahunit1',
            'perubahan' => 'Perubahan',
            'survived1' => 'Survived1',
            'survived2' => 'Survived2',
            'survived3' => 'Survived3',
            'survivalrate1' => 'Survivalrate1',
            'survivalrate2' => 'Survivalrate2',
            'survivalrate3' => 'Survivalrate3',
            'jumlahunit' => 'Jumlahunit',
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
