<?php

use yii\db\Migration;

/**
 * Class m180621_095357_update_pasport_table
 */
class m180621_095357_update_pasport_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey(
            'fk-user_passport-form_participation_id',
            'user_passport'
        );

        $this->dropForeignKey(
            'fk-user_passport-object_type',
            'user_passport'
        );

        $this->dropColumn('user_passport', 'type_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('user_passport', 'type_id', $this->integer());

        $this->addForeignKey(
            'fk-user_passport-object_type',
            'user_passport',
            'type_id',
            'object_type',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-user_passport-form_participation_id',
            'user_passport',
            'form_participation_id',
            'form_participation',
            'id',
            'CASCADE'
        );
    }

}
