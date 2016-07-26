<?php

use yii\db\Migration;

class m160725_122018_temp_jumlahUnit extends Migration
{
   public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%temp_entry}}', [
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
            'jumlahmasuk' => $this->bigInteger()
                            ], $tableOptions);
        $this->createTable('{{%temp_exit}}', [
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
             'jumlahkeluar' => $this->bigInteger()
                            ], $tableOptions);
        $this->createTable('{{%temp_jumlah0}}', [
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
             'jumlahunit0' => $this->bigInteger()
                            ], $tableOptions);
        $this->createTable('{{%temp_jumlah1}}', [
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
             'jumlahunit1' => $this->bigInteger()
                ], $tableOptions);
        $this->createTable('{{%temp_beroperasi}}', [
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
             'beroperasi' => $this->bigInteger()
                            ], $tableOptions);
            }

    public function down() {
        $this->dropTable('{{%temp_entry}}');
        $this->dropTable('{{%temp_exit}}');
        $this->dropTable('{{%temp_jumlah0}}');
        $this->dropTable('{{%temp_jumlah1}}');
        $this->dropTable('{{%temp_beroperasi}}');
    }
}
