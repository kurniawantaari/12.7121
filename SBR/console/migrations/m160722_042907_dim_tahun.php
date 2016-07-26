<?php

use yii\db\Migration;

class m160722_042907_dim_tahun extends Migration {

    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%tahun}}', [
            'id' => $this->primaryKey(),
            'tahun' => $this->char(4)->notNull()->unique(),
                ], $tableOptions);
    }

    public function down() {
        $this->dropTable('{{%tahun}}');
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
