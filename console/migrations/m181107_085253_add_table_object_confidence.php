<?php


use yii\db\Migration;

/**
 * Class m181107_085253_add_table_object_confidence
 */
class m181107_085253_add_table_object_confidence extends Migration
{
    private $tableName = 'object_confidence';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'object_id' => $this->integer()->notNull(),
            'confidence_id' => $this->integer()->notNull(),
            'file_id' => $this->integer(),
            'rate' => $this->integer()->notNull()->defaultValue(0),
            'check' => $this->boolean()->notNull()->defaultValue(false),
        ]);

        $this->addPrimaryKey('idx-object_confidence_pk', $this->tableName, ['object_id', 'confidence_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropPrimaryKey('idx-object_confidence_pk', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
