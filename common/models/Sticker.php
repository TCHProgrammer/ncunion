<?php

namespace common\models;

use Yii;
use common\models\object\Object;

/**
 * This is the model class for table "sticker".
 *
 * @property int $id
 * @property string $title
 * @property string $code
 *
 * @property Object[] $objects
 */
class Sticker extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sticker';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'code'], 'required'],
            [['title', 'code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'code' => 'Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjects()
    {
        return $this->hasMany(Object::className(), ['sticker_id' => 'id']);
    }
}
