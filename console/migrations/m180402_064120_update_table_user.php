<?php

use yii\db\Migration;

class m180402_064120_update_table_user extends Migration
{

    public function safeUp()
    {
        $this->addColumn('user', 'first_name', $this->string());
        $this->addColumn('user', 'last_name', $this->string());
        $this->addColumn('user', 'middle_name', $this->string());
        $this->addColumn('user', 'phone', $this->string());
        $this->addColumn('user', 'company_name', $this->string());
    }

    public function safeDown()
    {
        $this->dropColumn('user', 'first_name');
        $this->dropColumn('user', 'last_name');
        $this->dropColumn('user', 'middle_name');
        $this->dropColumn('user', 'phone');
        $this->dropColumn('user', 'company_name');
    }

}
