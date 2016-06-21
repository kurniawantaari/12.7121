<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "history".
 *
 * @property integer $id
 * @property string $nama_tabel
 * @property integer $jumlah_hits
 * @property integer $flag
 */
class HistoryofTable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama_tabel', 'jumlah_hits'], 'required'],
            [['nama_tabel'], 'string'],
            [['jumlah_hits', 'flag'], 'integer'],
            [['nama_tabel'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_tabel' => 'Nama Tabel',
            'jumlah_hits' => 'Jumlah Hits',
            'flag' => 'Flag',
        ];
    }
}
