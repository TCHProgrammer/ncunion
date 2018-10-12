<?php

use yii\db\Migration;

/**
 * Class m181011_155011_add_city_idcolumn_into_object
 */
class m181011_155011_add_city_id_column_into_object extends Migration
{
    private $tableName = 'object';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'city_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropColumn($this->tableName, 'city_id');
    }
}
