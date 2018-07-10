<?php

namespace common\models\object;

use Yii;

/**
 * This is the model class for table "confidence_object".
 *
 * @property int $confidence_id
 * @property int $object_id
 *
 * @property Confidence $confidence
 * @property Object $object
 */
class ConfidenceObject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'confidence_object';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['confidence_id', 'object_id'], 'integer'],
            [['confidence_id'], 'exist', 'skipOnError' => true, 'targetClass' => Confidence::className(), 'targetAttribute' => ['confidence_id' => 'id']],
            [['object_id'], 'exist', 'skipOnError' => true, 'targetClass' => Object::className(), 'targetAttribute' => ['object_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'confidence_id' => Yii::t('app', 'Confidence ID'),
            'object_id' => Yii::t('app', 'Object ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfidence()
    {
        return $this->hasOne(Confidence::className(), ['id' => 'confidence_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObject()
    {
        return $this->hasOne(Object::className(), ['id' => 'object_id']);
    }
}
