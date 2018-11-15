<?php

use yii\db\Migration;

/**
 * Class m181114_054559_add_object_confidence_file_table
 */
class m181114_054559_add_object_confidence_file_table extends Migration
{
    private $tableName = 'object_confidence_file';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'doc' => $this->string(),
            'title' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
