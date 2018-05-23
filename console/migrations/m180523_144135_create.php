<?php

use yii\db\Migration;

/**
 * Class m180523_144135_create
 */
class m180523_144135_create extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('room_object_user', 'created_at', $this->integer());

        $this->createTable('room_finish_object', [
            'object_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'manager_id' => $this->integer(),
            'created_at' => $this->integer(),
            'comment' => $this->text(),
        ]);

        $this->createIndex(
            'idx-room_finish_object-object_id',
            'room_finish_object',
            'object_id'
        );

        $this->addForeignKey(
            'fk-room_finish_object-object',
            'room_finish_object',
            'object_id',
            'object',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-room_finish_object-user',
            'room_finish_object',
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
            'fk-room_finish_object-user',
            'room_finish_object'
        );

        $this->dropForeignKey(
            'fk-room_finish_object-object',
            'room_finish_object'
        );

        $this->dropIndex(
            'idx-room_finish_object-object_id',
            'room_finish_object'
        );

        $this->dropTable('room_finish_object');

        $this->dropColumn('room_object_user', 'created_at');
    }
}
