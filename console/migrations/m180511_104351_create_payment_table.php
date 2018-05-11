<?php

use yii\db\Migration;

/**
 * Handles the creation of table `payment`.
 */
class m180511_104351_create_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('payment', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'tariff_id' => $this->integer(),
            'price' => $this->decimal(11, 2),
            'discount' => $this->string(),
            'created_at' => $this->integer()
        ]);

        $this->addForeignKey(
            'fk-payment-user',
            'payment',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-payment-module_tariff',
            'payment',
            'tariff_id',
            'module_tariff',
            'id',
            'CASCADE'
        );

        $this->addColumn('user', 'subscribe_dt', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'subscribe_dt');

        $this->dropForeignKey(
            'fk-payment-module_tariff',
            'payment'
        );

        $this->dropForeignKey(
            'fk-payment-user',
            'payment'
        );

        $this->dropTable('payment');
    }
}
