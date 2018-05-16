<?php

use yii\db\Migration;

/**
 * Class m180516_112013_create_passport_tables
 */
class m180516_112013_create_passport_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('passport_attribute_checkbox', [
            'passport_id' => $this->integer(),
            'attribute_id' => $this->integer(),
            'group_id' => $this->integer()
        ]);

        $this->createTable('passport_attribute_radio', [
            'passport_id' => $this->integer(),
            'attribute_id' => $this->integer(),
            'group_id' => $this->integer()
        ]);

        $this->createIndex(
            'idx-passport_attribute_checkbox-group_id',
            'passport_attribute_checkbox',
            'group_id'
        );

        $this->createIndex(
            'idx-passport_attribute_radio-group_id',
            'passport_attribute_radio',
            'group_id'
        );

        $this->addForeignKey(
            'fk-passport_attribute_checkbox-attribute_checkbox',
            'passport_attribute_checkbox',
            'attribute_id',
            'attribute_checkbox',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-passport_attribute_checkbox-group_checkbox',
            'passport_attribute_checkbox',
            'group_id',
            'group_checkbox',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-passport_attribute_checkbox-user_passport',
            'passport_attribute_checkbox',
            'passport_id',
            'user_passport',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-passport_attribute_radio-attribute_radio',
            'passport_attribute_radio',
            'attribute_id',
            'attribute_radio',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-passport_attribute_radio-group_radio',
            'passport_attribute_radio',
            'group_id',
            'group_radio',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-passport_attribute_radio-user_passport',
            'passport_attribute_radio',
            'passport_id',
            'user_passport',
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
            'fk-passport_attribute_radio-user_passport',
            'passport_attribute_radio'
        );

        $this->dropForeignKey(
            'fk-passport_attribute_radio-group_radio',
            'passport_attribute_radio'
        );

        $this->dropForeignKey(
            'fk-passport_attribute_radio-attribute_radio',
            'passport_attribute_radio'
        );

        $this->dropForeignKey(
            'fk-passport_attribute_checkbox-user_passport',
            'passport_attribute_checkbox'
        );

        $this->dropForeignKey(
            'fk-passport_attribute_checkbox-group_checkbox',
            'passport_attribute_checkbox'
        );

        $this->dropForeignKey(
            'fk-passport_attribute_checkbox-attribute_checkbox',
            'passport_attribute_checkbox'
        );

        $this->dropIndex(
            'idx-passport_attribute_radio-group_id',
            'passport_attribute_radio'
        );

        $this->dropIndex(
            'idx-passport_attribute_checkbox-group_id',
            'passport_attribute_checkbox'
        );

        $this->dropTable('passport_attribute_radio');
        $this->dropTable('passport_attribute_checkbox');
    }

}
