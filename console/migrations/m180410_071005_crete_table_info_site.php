<?php

use yii\db\Migration;

/**
 * Class m180410_071005_crete_table_info_site
 */
class m180410_071005_crete_table_info_site extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(){

        $this->createTable('info_site', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'bot_title' => $this->string(),
            'descr' => $this->text(),
            'letter_email' => $this->string(),
            'letter_email_pass' => $this->string(),
            'letter_phone' => $this->string(),
            'supp_email' => $this->string(),
            'supp_phone' => $this->string(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(){

        $this->dropTable('info_site');

    }

}
