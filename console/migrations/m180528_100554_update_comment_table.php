<?php

use yii\db\Migration;

/**
 * Class m180528_100554_update_comment_table
 */
class m180528_100554_update_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('comment_object' , 'path', $this->string(350));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('comment_object', 'path');
    }

}
