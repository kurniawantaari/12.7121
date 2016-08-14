<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "history_tabel".
 *
 * @property integer $idtabel
 * @property string $jenis
 * @property integer $jumlah_hits
 * @property integer $flag
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
            [['jenis'], 'string'],
            [['jumlah_hits'], 'required'],
            [['jumlah_hits', 'flag'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idtabel' => 'Idtabel',
            'jenis' => 'Jenis',
            'jumlah_hits' => 'Jumlah Hits',
            'flag' => 'Flag',
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
}
