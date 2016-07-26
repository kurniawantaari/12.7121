<?php

use yii\db\Migration;

class m160726_180015_temp_survival extends Migration
{
    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%temp_survived1}}', [
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
            //measure
             'survived1' => $this->bigInteger()
                            ], $tableOptions);
        $this->createTable('{{%temp_survived2}}', [
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
            //measure
             'survived2' => $this->bigInteger()
                            ], $tableOptions);
        $this->createTable('{{%temp_survived3}}', [
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
                        //measure
            'survived3' => $this->bigInteger()
                            ], $tableOptions);
        }

    public function down() {
        $this->dropTable('{{%temp_survived1}}');
        $this->dropTable('{{%temp_survived2}}');
        $this->dropTable('{{%temp_survived3}}');
    }}
