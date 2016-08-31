<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "history_tabel".
 *
 * @property integer $idtabel
 * @property string $nmtabel
 * @property string $jenis
 * @property string $variabelvertikal
 * @property string $variabelhorizontal
 *
 * @property HistoryAttributes[] $historyAttributes
 * @property HistoryInstitusi[] $historyInstitusis
 * @property HistoryJaringanusaha[] $historyJaringanusahas
 * @property HistoryKdkategori[] $historyKdkategoris
 * @property HistoryKdkbli[] $historyKdkblis
 * @property HistoryKepemilikan[] $historyKepemilikans
 * @property HistoryLokasi[] $historyLokasis
 * @property HistoryStatusperusahaan[] $historyStatusperusahaans
 * @property HistoryTahun[] $historyTahuns
 * @property HistoryUnitstatistik[] $historyUnitstatistiks
 */
class HistoryTabel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'history_tabel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nmtabel', 'jenis', 'variabelvertikal', 'variabelhorizontal'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idtabel' => 'Idtabel',
            'nmtabel' => 'Nmtabel',
            'jenis' => 'Jenis',
            'variabelvertikal' => 'Variabelvertikal',
            'variabelhorizontal' => 'Variabelhorizontal',
                    ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistoryAttributes()
    {
        return $this->hasMany(HistoryAttributes::className(), ['idtabel' => 'idtabel']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistoryInstitusis()
    {
        return $this->hasMany(HistoryInstitusi::className(), ['idtabel' => 'idtabel']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistoryJaringanusahas()
    {
        return $this->hasMany(HistoryJaringanusaha::className(), ['idtabel' => 'idtabel']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistoryKdkategoris()
    {
        return $this->hasMany(HistoryKdkategori::className(), ['idtabel' => 'idtabel']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistoryKdkblis()
    {
        return $this->hasMany(HistoryKdkbli::className(), ['idtabel' => 'idtabel']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistoryKepemilikans()
    {
        return $this->hasMany(HistoryKepemilikan::className(), ['idtabel' => 'idtabel']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistoryLokasis()
    {
        return $this->hasMany(HistoryLokasi::className(), ['idtabel' => 'idtabel']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistoryStatusperusahaans()
    {
        return $this->hasMany(HistoryStatusperusahaan::className(), ['idtabel' => 'idtabel']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistoryTahuns()
    {
        return $this->hasMany(HistoryTahun::className(), ['idtabel' => 'idtabel']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistoryUnitstatistiks()
    {
        return $this->hasMany(HistoryUnitstatistik::className(), ['idtabel' => 'idtabel']);
    }
    public function getTabelById($id){
        return static::findOne(['id' => $id]);
    }
}
