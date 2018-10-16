<?php


namespace common\models\object;


use yii\db\ActiveRecord;

class Region extends ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'region';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['name'], 'required'],
      [['name'], 'string', 'max' => 50],
      [['name'], 'unique'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'name' => 'Название'
    ];
  }
}
