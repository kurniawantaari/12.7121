<?php

use yii\db\Migration;

class m160719_170756_klasifikasi_industri extends Migration
{
     public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%klasifikasi_industri}}', [
            'kdklasifikasi' => $this->string()->notNull()->unique(),
            'namaklasifikasi' => $this->string()->notNull(),
            'keterangan' => $this->string()->notNull(),
                           ], $tableOptions);
        $this->addPrimaryKey('klasifikasi_industri_pk','klasifikasi_industri','kdklasifikasi');
        $this->insert('klasifikasi_industri', [
            'kdklasifikasi' => 'besar',
            'namaklasifikasi' => 'Industri Besar',
            'keterangan'=>'100 dan lebih pekerja'
        ]);
        $this->insert('klasifikasi_industri', [
            'kdklasifikasi' => 'sedang',
            'namaklasifikasi' => 'Industri Sedang',
            'keterangan'=>'20-99 pekerja'
        ]);
        $this->insert('klasifikasi_industri', [
            'kdklasifikasi' => 'kecil',
            'namaklasifikasi' => 'Industri Kecil',
            'keterangan'=>'5-19 pekerja'
        ]);
        $this->insert('klasifikasi_industri', [
            'kdklasifikasi' => 'rt',
            'namaklasifikasi' => 'Industri Rumah Tangga',
            'keterangan'=>'1-4 pekerja'
        ]);
    }

    public function down() {
        $this->dropTable('{{%klasifikasi_industri}}');
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
