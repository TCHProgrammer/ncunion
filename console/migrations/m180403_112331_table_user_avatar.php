<?php

use yii\db\Migration;

/**
 * Class m180403_112331_table_user_avatar
 */
class m180403_112331_table_user_avatar extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_avatar', [
            'user_id' => $this->integer()->notNull(),
            'avatar' => $this->string()
        ]);

        $this->createIndex(
            'idx-user_avatar-user_id',
            'user_avatar',
            'user_id'
        );

        $this->addForeignKey(
            'fk-user_avatar-user',
            'user_avatar',
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
        $this->dropTable('user_avater');

        $this->dropIndex(
            'idx-user_avatar-user_id',
            'user_avatar'
        );

        $this->dropForeignKey(
            'fk-user_avatar-user',
            'user_avatar'
        );
    }

}
