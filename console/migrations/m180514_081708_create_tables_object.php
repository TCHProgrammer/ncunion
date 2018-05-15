<?php

use yii\db\Migration;

/**
 * Class m180514_081708_create_tables_object
 */
class m180514_081708_create_tables_object extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('object_attribute_checkbox', [
            'object_id' => $this->integer(),
            'attribute_id' => $this->integer(),
            'group_id' => $this->integer()
        ]);

        $this->createTable('attribute_checkbox', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'type_id' => $this->integer()->notNull()
        ]);

        $this->createTable('group_checkbox', [
            'id' => $this->primaryKey(),
            'attribute_id' => $this->integer()->notNull(),
            'title' => $this->string()
        ]);

        $this->createTable('object_attribute_radio', [
            'object_id' => $this->integer(),
            'attribute_id' => $this->integer(),
            'group_id' => $this->integer()
        ]);

        $this->createTable('attribute_radio', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'type_id' => $this->integer()->notNull()
        ]);

        $this->createTable('group_radio', [
            'id' => $this->primaryKey(),
            'attribute_id' => $this->integer()->notNull(),
            'title' => $this->string()
        ]);

        $this->addForeignKey(
            'fk-object_attribute_checkbox-attribute_checkbox',
            'object_attribute_checkbox',
            'attribute_id',
            'attribute_checkbox',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-object_attribute_checkbox-group_checkbox',
            'object_attribute_checkbox',
            'group_id',
            'group_checkbox',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-group_checkbox-attribute_checkbox',
            'group_checkbox',
            'attribute_id',
            'attribute_checkbox',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-attribute_checkbox-object_type',
            'attribute_checkbox',
            'type_id',
            'object_type',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-object_attribute_radio-attribute_radio',
            'object_attribute_radio',
            'attribute_id',
            'attribute_radio',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-object_attribute_radio-group_radio',
            'object_attribute_radio',
            'group_id',
            'group_radio',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-group_radio-attribute_radio',
            'group_radio',
            'attribute_id',
            'attribute_radio',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-attribute_radio-object_type',
            'attribute_radio',
            'type_id',
            'object_type',
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
            'fk-attribute_radio-object_type',
            'attribute_radio'
        );
        $this->dropForeignKey(
            'fk-group_radio-attribute_radio',
            'group_radio'
        );
        $this->dropForeignKey(
            'fk-object_attribute_radio-group_radio',
            'object_attribute_radio'
        );
        $this->dropForeignKey(
            'fk-object_attribute_radio-attribute_radio',
            'object_attribute_radio'
        );

        $this->dropForeignKey(
            'fk-attribute_checkbox-object_type',
            'attribute_checkbox'
        );
        $this->dropForeignKey(
            'fk-group_checkbox-attribute_checkbox',
            'group_checkbox'
        );
        $this->dropForeignKey(
            'fk-object_attribute_checkbox-group_checkbox',
            'object_attribute_checkbox'
        );
        $this->dropForeignKey(
            'fk-object_attribute_checkbox-attribute_checkbox',
            'object_attribute_checkbox'
        );

        $this->dropTable('group_radio');
        $this->dropTable('attribute_radio');
        $this->dropTable('object_attribute_radio');
        $this->dropTable('group_checkbox');
        $this->dropTable('attribute_checkbox');
        $this->dropTable('object_attribute_checkbox');
    }

}
