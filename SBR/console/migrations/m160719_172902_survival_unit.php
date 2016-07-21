<?php

use yii\db\Migration;

class m160719_172902_survival_unit extends Migration
{
     public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%survival_unit}}', [
            //dimensi
            'kddesa' => $this->char(3), //kode desa
            'kdkec' => $this->char(3), //kode kecamatan
            'kdkab' => $this->char(2), //kode kabupaten/kota
            'kdprop' => $this->char(2), //kode propinsi
            'kdkategori' => $this->char(1), //kode kategori 
            'kdkbli' => $this->char(5), //nomor kbli
            'statusperusahaan' => $this->char(1), //kondisi: aktif,tutup, tutup sementara, dll
            'unitstatistik' => $this->char(2), //es,eg,en,au
            'institusi' => $this->char(3), //sektor institusi
            'klasifikasiindustri' => $this->char(1), //industri besar/sedang/kecil/rt
            'tahun' => $this->char(4), //tahun snapshot
            //measure
            'jumlahunit' => $this->bigInteger(), //referensi ke tahun snapshot-3 tabel jumlah_unit
            'survived1' => $this->bigInteger(), //jumlah unit tahun snapshot-3 dan aktf snaphot -2
            'survived2' => $this->bigInteger(), //jumlah unit tahun snapshot-3 dan aktf snaphot -2 dan aktf snaphot -1
            'survived3' => $this->bigInteger()//jumlah unit tahun snapshot-3 dan aktf snaphot -2 dan aktf snaphot -1 dan aktf snaphot -1 dan aktf snaphot -0
                ], $tableOptions);
    }

    public function down() {
        $this->dropTable('{{%survival_unit}}');
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
