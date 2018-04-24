<?php

namespace common\modules\tariff\models;

use Yii;

/**
 * This is the model class for table "module_tariff".
 *
 * @property int $id
 * @property int $days
 * @property string $price
 * @property int $status
 * @property string $img
 * @property int $discount_id
 * @property string $title
 * @property string $top_title
 * @property string $bot_title
 * @property string $descr
 *
 * @property TariffDiscount $discount
 */
class Tariff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'module_tariff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['days', 'price'], 'required'],
            [['days', 'status', 'discount_id'], 'integer'],
            [['price'], 'number'],
            [['descr'], 'string'],
            [['img', 'title', 'top_title', 'bot_title'], 'string', 'max' => 255],
            [['discount_id'], 'exist', 'skipOnError' => true, 'targetClass' => TariffDiscount::className(), 'targetAttribute' => ['discount_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'days' => 'Дней',
            'price' => 'Цена',
            'status' => 'Активность',
            'img' => 'Изображение',
            'discount_id' => 'Скидка',
            'title' => 'Заголовок',
            'top_title' => 'Подзаголовок над изображением',
            'bot_title' => 'Подзаголовок под изображением',
            'descr' => 'Описание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscount()
    {
        return $this->hasOne(TariffDiscount::className(), ['id' => 'discount_id']);
    }
}
