<?php

namespace common\models\object;

use Yii;

/**
 * This is the model class for table "prescribed".
 *
 * @property int $id
 * @property string $title
 *
 * @property ObjectPrescribed[] $objectPrescribeds
 */
class Prescribed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prescribed';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectPrescribeds()
    {
        return $this->hasMany(ObjectPrescribed::className(), ['prescribed_id' => 'id']);
    }
}
