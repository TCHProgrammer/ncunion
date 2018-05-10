<?php

use yii\db\Migration;

/**
 * Class m180510_071019_update_object_file
 */
class m180510_071019_update_object_file extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('object_file', 'title', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('object_file', 'title');
    }

}
