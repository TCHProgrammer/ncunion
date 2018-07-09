<?php

use yii\db\Migration;

/**
 * Class m180709_094701_update_room_object_user_table
 */
class m180709_094701_update_room_object_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('room_object_user', 'consumption');

        $this->addColumn('room_object_user', 'term', $this->integer()->notNull());

        $this->addColumn('room_object_user', 'schedule_payments', $this->integer()->notNull());

        $this->addColumn('room_object_user', 'nks', $this->integer()->notNull());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('room_object_user', 'nks');

        $this->dropColumn('room_object_user', 'schedule_payments');

        $this->dropColumn('room_object_user', 'term');

        $this->addColumn('room_object_user', 'consumption', $this->integer()->notNull());
    }

}
