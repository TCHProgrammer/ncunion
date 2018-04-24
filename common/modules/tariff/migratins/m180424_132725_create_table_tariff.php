<?php

use yii\db\Migration;

/**
 * Class m180424_132725_create_table_tariff
 */
class m180424_132725_create_table_tariff extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('module_tariff', [
            'id' => $this->primaryKey(),
            'days' => $this->integer()->notNull(),
            'price' => $this->decimal(12,2)->notNull(),
            'status' => $this->integer(1),
            'img' => $this->string(),
            'discount_id' => $this->integer(),
            'title' => $this->string(),
            'top_title' => $this->string(),
            'bot_title' => $this->string(),
            'descr' => $this->text()
        ]);

        $this->createTable('module_tariff_discount', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'title' => $this->string(),
            'type' => $this->integer()->notNull(), // скидка %, простовый вычет
        ]);

        $this->addForeignKey(
            'fk-module_tariff-module_tariff_discount',
            'module_tariff',
            'discount_id',
            'module_tariff_discount',
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
            'fk-module_tariff-module_tariff_discount',
            'module_tariff'
        );

        $this->dropTable('module_tariff_discount');
        $this->dropTable('module_tariff');
    }

}
