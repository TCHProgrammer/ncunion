<?php

use yii\db\Migration;

/**
 * Class m180619_141958_update_user_passport
 */
class m180619_141958_update_user_passport extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('user_passport', 'amount');
        $this->dropColumn('user_passport', 'area');
        $this->dropColumn('user_passport', 'rooms');

        $this->addColumn('user_passport', 'amount_min', $this->integer());
        $this->addColumn('user_passport', 'amount_max', $this->integer());

        $this->addColumn('user_passport', 'area_min', $this->integer());
        $this->addColumn('user_passport', 'area_max', $this->integer());

        $this->addColumn('user_passport', 'rooms_min', $this->integer());
        $this->addColumn('user_passport', 'rooms_max', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user_passport', 'amount_min');
        $this->dropColumn('user_passport', 'amount_max');

        $this->dropColumn('user_passport', 'area_min');
        $this->dropColumn('user_passport', 'area_max');

        $this->dropColumn('user_passport', 'rooms_min');
        $this->dropColumn('user_passport', 'rooms_max');
    }

}
