<?php

use yii\db\Migration;

class m160721_044648_snapshot_list extends Migration {

    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%snapshot_list}}', [

            'id' => $this->primaryKey(),
            'name' => $this->string()->null(),
            'type' => $this->char(10)->null(), //tahunan, bulanan, triwulanan, etc.
            'created_date' => $this->dateTime()->null(),
            'updated_date' => $this->dateTime()->null(),
            'database_id' => $this->integer()->notNull()
                ], $tableOptions);
            }

    public function down() {
        $this->dropTable('{{%snapshot_list}}');
    }

}
