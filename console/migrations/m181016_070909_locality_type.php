<?php

use yii\db\Migration;

/**
 * Class m181016_070909_locality_type
 */
class m181016_070909_locality_type extends Migration
{
  private $tableName = 'locality_type';

  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->createTable($this->tableName, [
      'id' => $this->primaryKey(),
      'name' => $this->char(50)->notNull()
    ]);
    $data = [
      'Город',
      'Поселок',
      'Поселок городского типа',
      'Деревня',
      'Село'
    ];
    foreach ($data as $record) {
      $this->insert($this->tableName, ['name' => $record]);

    }
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
      echo "m181016_070909_locality_type cannot be reverted.\n";

      return false;
  }
  */
}
