<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post_tags`.
 */
class m180226_212123_create_post_tags_table extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%post_tags}}', [
            'post_id'         => $this->integer()->unsigned()->notNull(),
            'tag_id'         => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%post_tags}}');
    }
}
