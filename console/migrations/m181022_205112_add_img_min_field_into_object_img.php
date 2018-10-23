<?php

use yii\db\Migration;

/**
 * Class m181022_205112_add_img_min_field_into_object_img
 */
class m181022_205112_add_img_min_field_into_object_img extends Migration
{
    private $tableName = 'object_img';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'img_min', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'img_min');
    }
}
