<?php

use yii\db\Migration;

/**
 * Class m180614_090714_update_table_object
 */
class m180614_090714_update_table_object extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('object', 'order', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('object', 'order');
    }

}
