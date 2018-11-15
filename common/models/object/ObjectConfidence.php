<?php


namespace common\models\object;


class ObjectConfidence extends \yii\db\ActiveRecord
{
    /**
     * @property integer $object_id
     * @property integer $confidence_id
     * @property integer $file_id
     * @property integer $rate
     * @property boolean $check
     *
     */

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'object_confidence';
    }

    public static function primaryKey()
    {
        return ['object_id', 'confidence_id'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['object_id', 'confidence_id', 'file_id', 'check', 'rate'], 'safe'],
            [['object_id', 'confidence_id'], 'required'],
            [['object_id', 'confidence_id', 'file_id'], 'integer'],
            ['check', 'boolean'],
            ['check', 'default', 'value' => false],
            ['rate', 'integer', 'max' => 1000],
            ['rate', 'default', 'value' => 0]
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'object_id' => 'Id объекта',
            'confidence_id' => 'Id справки',
            'file_id' => 'Файл справки',
            'rate' => 'Рейтинг',
            'check' => ''
        ];
    }
    public function getFile()
    {
        if (isset($this->file_id)) {
            return ObjectConfidenceFile::find()->where(['id' => $this->file_id])->one();
        };
        return;
    }

    public function beforeDelete()
    {
        if (!empty($file = $this->getFile())) {
            $file->object_id = $this->object_id;
            $file->confidence_id = $this->confidence_id;
            $file->delete();
        }
    }
}
