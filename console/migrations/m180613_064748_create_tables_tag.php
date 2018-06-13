<?php

use yii\db\Migration;

/**
 * Class m180613_064748_create_tables_tag
 */
class m180613_064748_create_tables_tag extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('object_tag', [
            'object_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
        ]);

        $this->createTable('tag', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
        ]);

        $this->createIndex(
            'idx-object_tag-object_id',
            'object_tag',
            'object_id'
        );

        $this->addForeignKey(
            'fk-object_tag-object',
            'object_tag',
            'object_id',
            'object',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-object_tag-tag',
            'object_tag',
            'tag_id',
            'tag',
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
            'fk-object_tag-tag',
            'object_tag'
        );

        $this->dropForeignKey(
            'fk-object_tag-object',
            'object_tag'
        );

        $this->dropIndex(
            'idx-object_tag-object_id',
            'object_tag'
        );

        $this->dropTable('object_tag');

        $this->dropTable('tag');
    }
}
