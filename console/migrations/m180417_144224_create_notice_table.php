<?php

use yii\db\Migration;

/**
 * Handles the creation of table `notice`.
 */
class m180417_144224_create_notice_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('notice', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
        ]);

        $this->createTable('notice_user', [
            'notice_id' => $this->integer(),
            'user_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-notice_user-notice_id',
            'notice_user',
            'notice_id'
        );

        $this->createIndex(
            'idx-notice_user-user_id',
            'notice_user',
            'user_id'
        );

        $this->addForeignKey(
            'fk-notice_user-notice',
            'notice_user',
            'notice_id',
            'notice',
            'id',
            'CASCADE'
        );


        $this->addForeignKey(
            'fk-notice_user-user',
            'notice_user',
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
            'fk-notice_user-notice',
            'notice_user'
        );

        $this->dropForeignKey(
            'fk-notice_user-user',
            'notice_user'
        );

        $this->dropIndex(
            'idx-notice_user-notice_id',
            'notice_id'
        );

        $this->dropIndex(
            'idx-notice_user-user_id',
            'notice_id'
        );

        $this->dropTable('notice');

        $this->dropTable('notice_user');
    }
}
