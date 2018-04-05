<?php

use yii\db\Migration;

/**
 * Class m180405_093110_update_users_table
 */
class m180405_093110_update_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'check_email', $this->integer(1));
        $this->addColumn('user', 'check_phone', $this->integer(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'check_email');
        $this->dropColumn('user', 'check_phone');
    }

}
