<?php

use yii\db\Migration;

/**
 * Class m181011_021055_city
 */
class m181011_021055_city extends Migration
{
  private $tableName = 'city';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->createTable($this->tableName, [
        'id' => $this->primaryKey(),
        'name' => $this->char(50)->notNull()
      ]);
      $this->createIndex('city_unique', $this->tableName, 'name', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropTable($this->tableName);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181011_021055_city cannot be reverted.\n";

        return false;
    }
    */
}
