<?php

use yii\db\Migration;

class m160813_115300_history extends Migration {

    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%history_kdkbli}}', [
            'idtabel' => $this->integer(),
            'kdkbli' => $this->char(5), //nomor kbli
                ], $tableOptions);

        $this->createTable('{{%history_statusperusahaan}}', [
            'idtabel' => $this->integer(),
            'statusperusahaan' => $this->char(1), //kondisi: aktif,tutup, tutup sementara, dll
                ], $tableOptions);
        $this->createTable('{{%history_unitstatistik}}', [
            'idtabel' => $this->integer(),
            'unitstatistik' => $this->char(2), //es,eg,en,au
                ], $tableOptions);
        $this->createTable('{{%history_kdkategori}}', [
            'idtabel' => $this->integer(),
            'kdkategori' => $this->char(1), //kode kategori 
                ], $tableOptions);
        $this->createTable('{{%history_institusi}}', [
            'idtabel' => $this->integer(),
            'institusi' => $this->char(3), //sektor institusi
                ], $tableOptions);
        $this->createTable('{{%history_kepemilikan}}', [
            'idtabel' => $this->integer(),
            'kepemilikan' => $this->char(1),
                ], $tableOptions);
        $this->createTable('{{%history_jaringanusaha}}', [
            'idtabel' => $this->integer(),
            'jaringanusaha' => $this->char(1),
                ], $tableOptions);
        $this->createTable('{{%history_tahun}}', [
            'idtabel' => $this->integer(),
            'tahun' => $this->char(4), //tahun snapshot
                ], $tableOptions);
        $this->createTable('{{%history_lokasi}}', [
            'idtabel' => $this->integer(),
            'kddesa' => $this->char(3), //kode desa
            'kdkec' => $this->char(3), //kode kecamatan
            'kdkab' => $this->char(2), //kode kabupaten/kota
            'kdprop' => $this->char(2), //kode propinsi
                ], $tableOptions);

        $this->createTable('{{%history_attributes}}', [
            //nilai true jika dipakai
            'idtabel' => $this->integer(),
            'jumlahmasuk' => $this->boolean(),
            'jumlahkeluar' => $this->boolean(),
            'jumlahunit0' => $this->boolean(),
            'beroperasi' => $this->boolean(),
            'jumlahunit1' => $this->boolean(),
            'perubahan' => $this->boolean(),
            'survived1' => $this->boolean(),
            'survived2' => $this->boolean(),
            'survived3' => $this->boolean(),
            'survivalrate1' => $this->boolean(),
            'survivalrate2' => $this->boolean(),
            'survivalrate3' => $this->boolean(),
                ], $tableOptions);

        $this->createTable('{{%history_tabel}}', [
            'idtabel' => $this->primaryKey(),
            'jenis' => $this->char(2),
            'jumlah_hits' => $this->integer()->notNull(),
            'flag' => $this->boolean()->notNull()->defaultValue(0), //false is nggak masuk ke suggestion
                ], $tableOptions);

        $this->addForeignKey('history_kdkbli_pk', '{{%history_kdkbli}}', 'idtabel', 'history_tabel', 'idtabel', 'CASCADE', 'CASCADE');
        $this->addForeignKey('history_statusperusahaan_pk', '{{%history_statusperusahaan}}', 'idtabel', 'history_tabel', 'idtabel', 'CASCADE', 'CASCADE');
        $this->addForeignKey('history_unitstatistik_pk', '{{%history_unitstatistik}}', 'idtabel', 'history_tabel', 'idtabel', 'CASCADE', 'CASCADE');
        $this->addForeignKey('history_kdkategori_pk', '{{%history_kdkategori}}', 'idtabel', 'history_tabel', 'idtabel', 'CASCADE', 'CASCADE');
        $this->addForeignKey('history_tahun_pk', '{{%history_tahun}}', 'idtabel', 'history_tabel', 'idtabel', 'CASCADE', 'CASCADE');
        $this->addForeignKey('history_institusi_pk', '{{%history_institusi}}', 'idtabel', 'history_tabel', 'idtabel', 'CASCADE', 'CASCADE');
        $this->addForeignKey('history_kepemilikan_pk', '{{%history_kepemilikan}}', 'idtabel', 'history_tabel', 'idtabel', 'CASCADE', 'CASCADE');
        $this->addForeignKey('history_jaringanusaha_pk', '{{%history_jaringanusaha}}', 'idtabel', 'history_tabel', 'idtabel', 'CASCADE', 'CASCADE');
        $this->addForeignKey('history_lokasi_pk', '{{%history_lokasi}}', 'idtabel', 'history_tabel', 'idtabel', 'CASCADE', 'CASCADE');
        $this->addForeignKey('history_attributes_pk', '{{%history_attributes}}', 'idtabel', 'history_tabel', 'idtabel', 'CASCADE', 'CASCADE');
    }

    public function down() {
        $this->dropTable('{{%history_tabel}}');
        $this->dropTable('{{%history_kdkbli}}');
        $this->dropTable('{{%history_statusperusahaan}}');
        $this->dropTable('{{%history_unitstatistik}}');
        $this->dropTable('{{%history_kdkategori}}');
        $this->dropTable('{{%history_tahun}}');
        $this->dropTable('{{%history_institusi}}');
        $this->dropTable('{{%history_kepemilikan}}');
        $this->dropTable('{{%history_jaringanusaha}}');
        $this->dropTable('{{%history_lokasi}}');
        $this->dropTable('{{%history_attributes}}');
    }

}
