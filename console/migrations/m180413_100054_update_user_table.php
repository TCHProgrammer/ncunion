<?php

use yii\db\Migration;

/**
 * Class m180413_100054_update_user_table
 */
class m180413_100054_update_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'email_confirm_token', $this->string());
        $this->addColumn('user', 'phone_confirm_token', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'email_confirm_token');
        $this->dropColumn('user', 'phone_confirm_token');

    }
}
