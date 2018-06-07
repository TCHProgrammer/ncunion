<?php

use yii\db\Migration;

/**
 * Class m180607_141037_update_rbac
 */
class m180607_141037_update_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-auth_assignment-user',
            'auth_assignment',
            'user_id',
            'user',
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
            'fk-auth_assignment-user',
            'auth_assignment'
        );
    }

}
