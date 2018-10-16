<?php

use yii\db\Migration;

/**
 * Class m181016_070917_region
 */
class m181016_070917_region extends Migration
{
  private $tableName = 'region';

  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->createTable($this->tableName, [
      'id' => $this->primaryKey(),
      'name' => $this->char(50)->notNull()
    ]);
    $this->createIndex('region_unique', $this->tableName, 'name', true);
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
      echo "m181016_070917_region cannot be reverted.\n";

      return false;
  }
  */
}
