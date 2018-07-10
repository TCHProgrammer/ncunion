<?php

namespace common\models\object;

use Yii;

/**
 * This is the model class for table "confidence".
 *
 * @property int $id
 * @property string $title
 *
 * @property ConfidenceObject[] $confidenceObjects
 */
class Confidence extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'confidence';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfidenceObjects()
    {
        return $this->hasMany(ConfidenceObject::className(), ['confidence_id' => 'id']);
    }
}
