<?php

use yii\db\Migration;

/**
 * Class m180420_074006_creat_sticers_tables
 */
class m180420_074006_creat_sticers_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('object','status_object', $this->integer());
        $this->addColumn('object','sticker_id', $this->integer());
        $this->addColumn('object','created_at', $this->integer()->notNull());
        $this->addColumn('object','updated_at', $this->integer()->notNull());
        $this->addColumn('object','close_at', $this->integer());

        $this->createTable('sticker', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'code' => $this->string()->notNull()
        ]);

        $this->addForeignKey(
            'fk-object-sticker',
            'object',
            'sticker_id',
            'sticker',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('object', 'status_object');
        $this->dropColumn('object', 'sticker_id');
        $this->dropColumn('object', 'created_at');
        $this->dropColumn('object', 'updated_at');
        $this->dropColumn('object', 'close_at');

        $this->dropTable('sticker');

        $this->dropForeignKey(
            'fk-object-sticker',
            'object'
        );
    }
}
