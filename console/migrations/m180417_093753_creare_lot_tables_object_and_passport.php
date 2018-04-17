<?php

use yii\db\Migration;

/**
 * Class m180417_093753_creare_lot_tables_object_and_passport
 */
class m180417_093753_creare_lot_tables_object_and_passport extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(){

        $this->addColumn('user', 'user_passport_id', $this->integer());

        /**
         * Создаём таблицы с паспортом
         */
        $this->createTable('user_passport', [
            'id' => $this->primaryKey(),
            'amount' => $this->decimal(11,2),
            'type_id' => $this->integer(),
            'form_participation_id' => $this->integer(),
        ]);

        $this->createTable('form_participation', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()
        ]);

        $this->createTable('passport_attribute', [
           'passport_id' => $this->integer()->notNull(),
           'attribute_id' => $this->integer()->notNull(),
           'value' => $this->string()->notNull(),
        ]);

        $this->createIndex(
            'idx-passport_attribute-passport_id',
            'passport_attribute',
            'passport_id'
        );

        $this->createIndex(
            'idx-passport_attribute-attribute_id',
            'passport_attribute',
            'attribute_id'
        );


        /**
         * Создаём таблицы для объектов
         */
        $this->createTable('object_img', [
           'object_id' => $this->integer(),
           'img' => $this->string()
        ]);

        $this->createIndex(
            'idx-object_img-object_id',
            'object_img',
            'object_id'
        );

        $this->createTable('object_type', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
        ]);

        $this->createTable('object_file', [
            'object_id' => $this->integer(),
            'file' => $this->string()
        ]);

        $this->createTable('object', [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer()->notNull(),
            'status' => $this->integer(1)->notNull(),
            'title' =>$this->string()->notNull(),
            'descr' => $this->text(),
            'place_km' => $this->integer(),
            'amount' => $this->decimal(11,2),
            'address' => $this->string(),
            'address_map' => $this->string(),
            'area' => $this->integer(),
            'rooms' => $this->integer(),
            'owner' => $this->string(),
            'price_cadastral' => $this->integer(),
            'price_tian' => $this->integer(),
            'price_market' => $this->integer(),
            'price_liquidation' => $this->integer(),
        ]);

        $this->createTable('prescribed', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
        ]);

        $this->createTable('object_prescribed', [
            'object_id' => $this->integer(),
            'prescribed_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-object_prescribed-object_id',
            'object_prescribed',
            'object_id'
        );

        $this->createTable('attribute', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'type_id'=> $this->integer()->notNull(),
        ]);

        $this->createTable('object_attribute', [
            'object_id' => $this->integer(),
            'attribute_id' => $this->integer(),
            'value' => $this->string(),
        ]);

        $this->createIndex(
            'idx-object_attribute-object_id',
            'object_attribute',
            'object_id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(){

        $this->dropIndex(
            'idx-passport_attribute-passport_id',
            'passport_attribute'
        );

        $this->dropIndex(
            'idx-passport_attribute-attribute_id',
            'passport_attribute'
        );

        $this->dropIndex(
            'idx-object_img-object_id',
            'object_img'
        );

        $this->dropIndex(
            'idx-object_prescribed-object_id',
            'object_prescribed'
        );


        $this->dropIndex(
            'idx-object_attribute-object_id',
            'object_attribute'
        );

        $this->dropColumn('user', 'user_passport_id');

        $this->dropTable('user_passport');

        $this->dropTable('form_participation');

        $this->dropTable('passport_attribute');

        $this->dropTable('object_img');

        $this->dropTable('object_category');

        $this->dropTable('object_file');

        $this->dropTable('object');

        $this->dropTable('prescribed');

        $this->dropTable('object_prescribed');

        $this->dropTable('attribute');

        $this->dropTable('object_attribute');
    }
}
