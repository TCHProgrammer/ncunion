<?php

use yii\db\Migration;

/**
 * Class m180618_141242_update_tables
 */
class m180618_141242_update_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('room_object_user', 'active', $this->integer(1));

        $this->dropTable('room_finish_object');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('room_object_user', 'active');
    }

}
