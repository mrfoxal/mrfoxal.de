<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tags`.
 */
class m180226_212102_create_tags_table extends Migration
{

    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%tags}}', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(255)->unsigned()->notNull(),
            'user_id'    => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
            'slug'       => $this->string(255)->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%tags}}');
    }
}
