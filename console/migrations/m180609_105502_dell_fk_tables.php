<?php

use yii\db\Migration;

/**
 * Class m180609_105502_dell_fk_table_and_table_and_add_new_tables_tags
 */
class m180609_105502_dell_fk_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        /* удаляем всё связанное со стикерами */
        $this->dropForeignKey(
            'fk-object-sticker',
            'object'
        );
        $this->dropColumn('object', 'sticker_id');
        $this->dropTable('sticker');

        /* удаляем всё связанное с таблицей prescribed */
        $this->dropForeignKey(
            'fk-object_prescribed-object',
            'object_prescribed'
        );
        $this->dropForeignKey(
            'fk-object_prescribed-prescribed',
            'object_prescribed'
        );
        $this->dropIndex(
            'idx-object_prescribed-object_id',
            'object_prescribed'
        );
        $this->dropTable('prescribed');
        $this->dropTable('object_prescribed');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }

}
