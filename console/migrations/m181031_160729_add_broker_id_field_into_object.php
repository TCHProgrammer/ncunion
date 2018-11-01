<?php

use yii\db\Migration;

/**
 * Class m181031_160729_add_broker_id_field_into_object
 */
class m181031_160729_add_broker_id_field_into_object extends Migration
{
    private $tableName = 'object';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'broker_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'broker_id');
    }
}
