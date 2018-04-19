<?php

namespace common\models\object;

use Yii;

/**
 * This is the model class for table "object_prescribed".
 *
 * @property int $object_id
 * @property int $prescribed_id
 *
 * @property Object $object
 * @property Prescribed $prescribed
 */
class ObjectPrescribed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'object_prescribed';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['object_id', 'prescribed_id'], 'integer'],
            [['object_id'], 'exist', 'skipOnError' => true, 'targetClass' => Object::className(), 'targetAttribute' => ['object_id' => 'id']],
            [['prescribed_id'], 'exist', 'skipOnError' => true, 'targetClass' => Prescribed::className(), 'targetAttribute' => ['prescribed_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'object_id' => 'Object ID',
            'prescribed_id' => 'Prescribed ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObject()
    {
        return $this->hasOne(Object::className(), ['id' => 'object_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrescribed()
    {
        return $this->hasOne(Prescribed::className(), ['id' => 'prescribed_id']);
    }
}
