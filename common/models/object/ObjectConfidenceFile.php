<?php


namespace common\models\object;

use yii;

class ObjectConfidenceFile extends \yii\db\ActiveRecord
{
    /**
     * @property integer $id
     * @property string $title
     * @property string $doc
     *
     */
    public $confidence_id;
    public $object_id;

    public static function tableName()
    {
        return 'object_confidence_file';
    }

    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['object_id', 'confidence_id', 'title', 'doc'], 'safe'],
            [['object_id', 'confidence_id', 'id'], 'integer'],
            [['title', 'doc'], 'required'],
            [['doc'], 'file', 'maxFiles' => 1, 'extensions' => 'txt, pdf, cvg, doc, docx, ods, xls, xlsx, jpeg, jpg'],
            [['doc', 'title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'doc' => 'Справка',
            'title' => 'Название справки'
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (isset($this->confidence_id) && isset($this->object_id)) {
            $objectConfidence = ObjectConfidence::find()->where(['confidence_id' => $this->confidence_id, 'object_id' => $this->object_id])->one();
            if (!empty($objectConfidence)) {
                $objectConfidence->file_id = $this->id;
                $objectConfidence->save();
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()){
            $objectConfidence = ObjectConfidence::find()->where(['object_id' => $this->object_id, 'confidence_id' => $this->confidence_id])->one();
            if (isset($objectConfidence)) {
                $objectConfidence->file_id = null;
                $objectConfidence->save();
            }

            $dir = Yii::getAlias('@frontend') . '/web/' . $this->doc;

            if (file_exists($dir)){
                unlink($dir);
            }

            $delDir = Yii::getAlias('@frontend') . '/web/uploads/objects/doc/' . $this->object_id . '/conf/';
            $arrFiles = scandir($delDir);
            if (!isset($arrFiles[2])){
                rmdir($delDir);
            }
            return true;
        }else{
            return false;
        }
    }
}
