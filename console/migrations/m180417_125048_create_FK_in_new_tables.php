<?php

use yii\db\Migration;

/**
 * Class m180417_125048_create_FK_in_new_tables
 */
class m180417_125048_create_FK_in_new_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addForeignKey(
            'fk-user-user_passport',
            'user',
            'user_passport_id',
            'user_passport',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-user_passport-form_participation_id',
            'user_passport',
            'form_participation_id',
            'form_participation',
            'id',
            'CASCADE'
        );


        $this->addForeignKey(
            'fk-user_passport-object_type',
            'user_passport',
            'type_id',
            'object_type',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-passport_attribute-user_passport',
            'passport_attribute',
            'passport_id',
            'user_passport',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-passport_attribute-attribute',
            'passport_attribute',
            'attribute_id',
            'attribute',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-object_img-object',
            'object_img',
            'object_id',
            'object',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-object_file-object',
            'object_file',
            'object_id',
            'object',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-object_prescribed-object',
            'object_prescribed',
            'object_id',
            'object',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-object_prescribed-prescribed',
            'object_prescribed',
            'prescribed_id',
            'prescribed',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-object_attribute-object',
            'object_attribute',
            'object_id',
            'object',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-object_attribute-attribute',
            'object_attribute',
            'attribute_id',
            'attribute',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-object-object_type',
            'object',
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
            'fk-user-user_passport',
            'user'
        );

        $this->dropForeignKey(
            'fk-user_passport-form_participation_id',
            'user_passport'
        );

        $this->dropForeignKey(
            'fk-user_passport-object_type',
            'user_passport'
        );

        $this->dropForeignKey(
            'fk-passport_attribute-user_passport',
            'passport_attribute'
        );

        $this->dropForeignKey(
            'fk-passport_attribute-attribute',
            'passport_attribute'
        );

        $this->dropForeignKey(
            'fk-object_img-object',
            'object_img'
        );

        $this->dropForeignKey(
            'fk-object_file-object',
            'object_file'
        );

        $this->dropForeignKey(
            'fk-object_prescribed-object',
            'object_prescribed'
        );

        $this->dropForeignKey(
            'fk-object_prescribed-prescribed',
            'object_prescribed'
        );

        $this->dropForeignKey(
            'fk-object_attribute-object',
            'object_attribute'
        );

        $this->dropForeignKey(
            'fk-object_attribute-attribute',
            'object_attribute'
        );

        $this->dropForeignKey(
            'fk-object-object_type',
            'object'
        );

    }
}
