<?php

use yii\db\Migration;

/**
 * Class m190114_150355_add_land_price_fields_into_object_table
 */
class m190114_150355_add_land_price_fields_into_object_table extends Migration
{
    private $tableName = 'object';


    public function safeUp()
    {
        $this->addColumn('{{%' . $this->tableName . '}}', 'land_price_cadastral', $this->float());
        $this->addColumn('{{%' . $this->tableName . '}}', 'land_price_tian', $this->float());
        $this->addColumn('{{%' . $this->tableName . '}}', 'land_price_market', $this->float());
        $this->addColumn('{{%' . $this->tableName . '}}', 'land_price_liquidation', $this->float());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%' . $this->tableName . '}}', 'land_price_cadastral');
        $this->dropColumn('{{%' . $this->tableName . '}}', 'land_price_tian');
        $this->dropColumn('{{%' . $this->tableName . '}}', 'land_price_market');
        $this->dropColumn('{{%' . $this->tableName . '}}', 'land_price_liquidation');
    }
}
