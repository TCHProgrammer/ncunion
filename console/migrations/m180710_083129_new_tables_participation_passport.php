<?php

use yii\db\Migration;

/**
 * Class m180710_083129_new_tables_participation_passport
 */
class m180710_083129_new_tables_participation_passport extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('participation_passport', [
            'participation_id' => $this->integer(),
            'passport_id' => $this->integer()
        ]);

        $this->createIndex(
            'idx-participation_passport-passport_id',
            'participation_passport',
            'passport_id'
        );

        $this->addForeignKey(
            'fk-participation_passport-form_participation',
            'participation_passport',
            'participation_id',
            'form_participation',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-participation_passport-user_passport',
            'participation_passport',
            'passport_id',
            'user_passport',
            'id',
            'CASCADE'
        );

        $this->dropColumn('user_passport','form_participation_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('user_passport','form_participation_id', $this->integer());

        $this->dropForeignKey(
            'fk-participation_passport-user_passport',
            'participation_passport'
        );

        $this->dropForeignKey(
            'fk-participation_passport-form_participation',
            'participation_passport'
        );


        $this->dropIndex(
            'idx-participation_passport-passport_id',
            'participation_passport'
        );

        $this->dropTable('participation_passport');
    }
}
