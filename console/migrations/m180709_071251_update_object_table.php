<?php

use yii\db\Migration;

/**
 * Class m180709_071251_update_object_table
 */
class m180709_071251_update_object_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('object', 'rate', $this->integer());

        $this->addColumn('object', 'term', $this->integer());

        $this->addColumn('object', 'schedule_payments', $this->integer());

        $this->addColumn('object', 'nks', $this->integer());

        $this->dropColumn('object', 'area');

        $this->addColumn('object', 'area', $this->decimal(11, 1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('object', 'area');

        $this->addColumn('object', 'area', $this->integer());

        $this->dropColumn('object', 'nks');

        $this->dropColumn('object', 'schedule_payments');

        $this->dropColumn('object', 'term');

        $this->dropColumn('object', 'rate');
    }

}
