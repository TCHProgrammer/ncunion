<?php

use yii\db\Migration;

/**
 * Class m180511_081320_update_user_passport
 */
class m180511_081320_update_user_passport extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_passport' , 'area', $this->integer());
        $this->addColumn('user_passport' , 'rooms', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user_passport', 'area');
        $this->dropColumn('user_passport', 'rooms');
    }

}
