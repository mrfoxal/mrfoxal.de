<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comments`.
 */
class m180219_202821_create_comments_table extends Migration
{

    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%comments}}', [
            'id'            => $this->primaryKey(),
            'material_type' => $this->smallInteger()->notNull(),
            'material_id'   => $this->bigInteger()->notNull(),
            'text'          => $this->text()->null(),
            'user_id'       => $this->integer()->unsigned()->null(),
            'user_name'     => $this->string()->null(),
            'user_email'    => $this->string()->null(),
            'user_ip'       => $this->integer()->unsigned()->null(),
            'parent_id'     => $this->integer()->unsigned()->null(),
            'language_id'   => $this->smallInteger()->null(),
            'is_replied'    => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'is_approved'   => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'is_deleted'    => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'created_at'    => $this->dateTime()->notNull(),
            'updated_at'    => $this->timestamp(),
        ], $tableOptions
        );

        $this->createIndex('material', '{{%comments}}', ['material_type', 'material_id']);
        $this->createIndex('sorting', '{{%comments}}', ['parent_id', 'created_at']);
        $this->createIndex('visible', '{{%comments}}', 'is_deleted');
    }

    public function down()
    {
        $this->dropIndex('material', '{{%comments}}');
        $this->dropIndex('sorting', '{{%comments}}');
        $this->dropIndex('visible', '{{%comments}}');

        $this->dropTable('{{%comments}}');
    }
}
