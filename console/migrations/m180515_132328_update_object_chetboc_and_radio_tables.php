<?php

use yii\db\Migration;

/**
 * Class m180515_132328_update_object_chetboc_and_radio_tables
 */
class m180515_132328_update_object_chetboc_and_radio_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-object_attribute_checkbox-object',
            'object_attribute_checkbox',
            'object_id',
            'object',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-object_attribute_radio-object',
            'object_attribute_radio',
            'object_id',
            'object',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-object_attribute_checkbox-group_id',
            'object_attribute_checkbox',
            'group_id'
        );

        $this->createIndex(
            'idx-id_book_author-group_id',
            'object_attribute_radio',
            'group_id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-id_book_author-group_id',
            'group_id'
        );

        $this->dropIndex(
            'idx-object_attribute_checkbox-group_id',
            'group_id'
        );

        $this->dropForeignKey(
            'fk-object_attribute_radio-object',
            'object_attribute_radio'
        );

        $this->dropForeignKey(
            'fk-object_attribute_checkbox-object',
            'object_attribute_checkbox'
        );
    }

}
