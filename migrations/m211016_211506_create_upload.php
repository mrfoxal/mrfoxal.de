<?php

use yii\db\Migration;

/**
 * Class m211016_211506_create_upload
 */
class m211016_211506_create_upload extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%upload}}', [
            'id'         => $this->primaryKey(),
            'filename'   => $this->string(255)->notNull(),
            'hashname'  => $this->string(255)->notNull(),
            'filesize'  => $this->string(255)->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('upload');
    }
}
