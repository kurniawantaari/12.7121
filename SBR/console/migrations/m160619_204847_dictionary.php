<?php

use yii\db\Migration;

class m160619_204847_dictionary extends Migration {

    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%dictionary}}', [
            'id' => $this->primaryKey(),
            'term' => $this->string()->notNull()->unique(),
            'description' => $this->string()->notNull(),
                ], $tableOptions);
    }

    public function down() {
        $this->dropTable('{{%dictionary}}');
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
