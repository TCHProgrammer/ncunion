<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "info_site".
 *
 * @property string $title
 * @property string $bot_title
 * @property string $descr
 * @property string $letter_email
 * @property string $letter_email_pass
 * @property string $letter_phone
 * @property string $supp_email
 * @property string $supp_phone
 */
class InfoSite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'info_site';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descr'], 'string'],
            [['title', 'bot_title', 'letter_email', 'letter_email_pass', 'letter_phone', 'supp_email', 'supp_phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Название сайта',
            'bot_title' => 'Подпись сайта',
            'descr' => 'Описание сайта',
            'letter_email' => 'email для отправки почты',
            'letter_email_pass' => 'пароль от email для отправки почты',
            'letter_phone' => 'Телефон указанный в почте',
            'supp_email' => 'Email технической поддержки',
            'supp_phone' => 'Телефон технической поддержки',
        ];
    }
}
