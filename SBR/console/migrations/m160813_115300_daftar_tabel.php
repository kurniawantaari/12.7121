<?php

use yii\db\Migration;

class m160813_115300_daftar_tabel extends Migration
{
    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%daftar_tabel}}', [
            'id' => $this->primaryKey(),
            'jenis'=>$this->char(2)->notNull(),
            'attributes'=>$this->string(),
            'years'=>$this->string(),
            
            'jumlah_hits' => $this->integer()->notNull(),
            'flag'=>$this->boolean()->notNull()->defaultValue(0),//false is nggak masuk ke suggestion
                ], $tableOptions);
    }

    public function down() {
        $this->dropTable('{{%history}}');
    }
}
