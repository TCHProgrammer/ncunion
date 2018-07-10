<?php

use yii\db\Migration;

/**
 * Class m180710_125221_confidence_tables
 */
class m180710_125221_confidence_tables extends Migration
{
    public function safeUp()
    {
        $this->createTable('confidence', [
            'id' => $this->primaryKey(),
            'title' => $this->string()
        ]);

        $this->createTable('confidence_object', [
            'confidence_id' => $this->integer(),
            'object_id' => $this->integer()
        ]);

        $this->createIndex(
            'idx-confidence_object-object_id',
            'confidence_object',
            'object_id'
        );

        $this->addForeignKey(
            'fk-confidence_object-confidence',
            'confidence_object',
            'confidence_id',
            'confidence',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-confidence_object-object',
            'confidence_object',
            'object_id',
            'object',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-confidence_object-object',
            'confidence_object'
        );

        $this->dropForeignKey(
            'fk-confidence_object-confidence',
            'confidence_object'
        );

        $this->dropIndex(
            'idx-confidence_object-object_id',
            'confidence_object'
        );

        $this->dropTable('confidence_object');

        $this->dropTable('confidence');
    }

}
