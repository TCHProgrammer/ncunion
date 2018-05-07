<?php

use yii\db\Migration;

/**
 * Class m180507_105127_update_object_table
 */
class m180507_105127_update_object_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('object_img', 'id', $this->primaryKey());
        $this->addColumn('object_img', 'sort', $this->integer(3));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('object_img', 'sort');
        $this->dropColumn('object_img', 'id');
    }

}
