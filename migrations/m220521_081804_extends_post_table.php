<?php

use yii\db\Migration;

/**
 * Class m220521_081804_extends_post_table
 */
class m220521_081804_extends_post_table extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->addColumn('{{%post}}', 'type_id', $this->tinyInteger(1)->defaultValue(1));
        $this->addColumn('{{%post}}', 'link',  $this->string()->null());
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropColumn('{{%post}}', 'type_id');
        $this->dropColumn('{{%post}}', 'link');
    }
}
