<?php

namespace common\modules\tariff\models;

use Yii;

/**
 * This is the model class for table "module_tariff_discount".
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property int $type
 *
 * @property Tariff[] $moduleTariffs
 */
class TariffDiscount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'module_tariff_discount';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type'], 'integer'],
            [['name', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название скидки',
            'title' => 'Надпись скидки',
            'type' => 'Тип',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModuleTariffs()
    {
        return $this->hasMany(Tariff::className(), ['discount_id' => 'id']);
    }
}
