<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m180222_190154_create_user_table extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%user}}', [
            'id'                   => $this->primaryKey(),
            'username'             => $this->string(255)->notNull(),
            'auth_key'             => $this->string(32)->notNull(),
            'password_hash'        => $this->string()->notNull(),
            'password_reset_token' => $this->string(),
            'email'                => $this->string(),
            'status'               => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at'           => $this->integer()->notNull(),
            'updated_at'           => $this->integer()->notNull()
        ], $tableOptions
        );

        $this->createIndex('idx-user-username-unique', '{{%user}}', 'username', true);
        $this->createIndex('idx-user-email-unique', '{{%user}}', 'email', true);

    }

    public function down()
    {
        $this->dropIndex('idx-user-username-unique', '{{%user}}');
        $this->dropIndex('idx-user-email-unique', '{{%user}}');

        $this->dropTable('{{%user}}');
    }
}
