<?php

use yii\db\Migration;

class m160719_172849_jumlah_unit extends Migration
{
    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%jumlah_unit}}', [
        //dimensi
        'kddesa'=>$this->char(3), //kode desa
        'kdkec'=>$this->char(3), //kode kecamatan
        'kdkab'=>$this->char(2), //kode kabupaten/kota
        'kdprop'=>$this->char(2),//kode propinsi
        'kdkategori'=>$this->char(1),//kode kategori 
        'kdkbli'=>$this->char(5),//nomor kbli
        'statusperusahaan'=>$this->char(1), //kondisi: aktif,tutup, tutup sementara, dll
        'unitstatistik'=>$this->char(2), //es,eg,en,au
        'institusi'=>$this->char(3), //sektor institusi
        'klasifikasiindustri'=>$this->char(1), //industri besar/sedang/kecil/rt
        'tahun'=>$this->char(9),//tahun snapshot-4 - tahun snapshot
        //measure
        'jumlahmasuk'=>$this->bigInteger(),//jumlah birth = count (id) yang tahun berdiri sama dengan tahun snapshot
        'jumlahkeluar'=>$this->bigInteger(),//jumlah death= count (id) yang thn kmrn aktif join tahun ini tutup on idA=idB
        //'beroperasi0'=>$this->bigInteger(),//jumlah awal tahun=jumlah akhir tahun kemarin
        'beroperasi'=>$this->bigInteger(),//jumlah yang aktif produksi/beroperasi = count yang aktif/alih usaha
        'jumlahunit'=>$this->bigInteger()//jumlah akhir tahun = count yang blm berproduksi/tutup sementara
        
                        ], $tableOptions);
    }
    public function down()
    {
       $this->dropTable('{{%jumlahunit}}');

    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
