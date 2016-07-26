<?php

use yii\db\Migration;

class m160719_172908_survival_birth extends Migration {

    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%survival_birth}}', [
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
            
            'kepemilikan'=>$this->char(1),
            'jaringanusaha'=>$this->char(1),
            'tahun' => $this->char(4), //tahun snapshot
            //measure
            'jumlahmasuk' => $this->bigInteger(), //referensi ke tahun snapshot-3 tabel jumlah_unit
            'survived1' => $this->bigInteger(), //jumlah yang masuk tahun snapshot-3 dan aktf snaphot -2
            'survived2' => $this->bigInteger(), //jumlah yang masuk tahun snapshot-3 dan aktf snaphot -2 dan aktf snaphot -1
            'survived3' => $this->bigInteger(), //jumlah yang masuk tahun snapshot-3 dan aktf snaphot -2 dan aktf snaphot -1 dan aktf snaphot -1 dan aktf snaphot -0
            'survivalrate1' => $this->double(),
            'survivalrate2' => $this->double(),
            'survivalrate3' => $this->double()
                ], $tableOptions);
    }

    public function down() {
        $this->dropTable('{{%survival_birth}}');
    }

}
