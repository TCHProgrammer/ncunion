<?php

namespace common\models\object;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "city".
 *
 * @property int $id
 * @property string $name
 * @property boolean $mkad
 *
 */
class City extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['name'], 'unique'],
            [['mkad'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'mkad' => 'Удаленность от МКАД',
        ];
    }
}
