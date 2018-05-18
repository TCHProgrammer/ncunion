<?php

use yii\db\Migration;

/**
 * Class m180517_131743_create_room_object_user
 */
class m180517_131743_create_room_object_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('room_object_user', [
            'object_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'sum' => $this->integer()->notNull(),
            'rate' => $this->integer()->null(),
            'consumption' => $this->integer()->notNull(),
            'comment' => $this->text(),
        ]);

        $this->createIndex(
            'idx-room_object_user-object_id',
            'room_object_user',
            'object_id'
        );

        $this->addForeignKey(
            'fk-room_object_user-object',
            'room_object_user',
            'object_id',
            'object',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-room_object_user-user',
            'room_object_user',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey(
            'fk-room_object_user-user',
            'room_object_user'
        );

        $this->dropForeignKey(
            'fk-room_object_user-object',
            'room_object_user'
        );

        $this->dropIndex(
            'idx-room_object_user-object_id',
            'room_object_user'
        );

        $this->dropTable('room_object_user');
    }

}
