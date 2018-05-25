<?php

use yii\db\Migration;

/**
 * Class m180524_123115_create_table_comment_obj
 */
class m180524_123115_create_table_comment_obj extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('comment_object', [
            'id' => $this->primaryKey(),
            'object_id' => $this->integer()->notNull(),
            'level' => $this->integer()->notNull(),
            'comment_id' => $this->integer(),
            'user_id' => $this->integer()->notNull(),
            'user_name' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),
            'datetime' => $this->dateTime()->notNull()
        ]);

        $this->addForeignKey(
            'fk-comment_object-object',
            'comment_object',
            'object_id',
            'object',
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
            'fk-comment_object-object',
            'comment_object'
        );

        $this->dropTable('comment_object');
    }

}
