<?php

namespace common\models\object;

use Yii;

/**
 * This is the model class for table "object_file".
 *
 * @property int $object_id
 * @property string $doc
 * @property string $title
 *
 * @property Object $object
 */
class ObjectFile extends \yii\db\ActiveRecord
{
    public $docFile;

    public static function tableName()
    {
        return 'object_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'doc'], 'required'],
            [['object_id'], 'integer'],
            [['doc'], 'file', 'maxFiles' => 0, 'extensions' => 'txt, pdf, cvg, doc, docx, ods, xls, xlsx, jpeg, jpg'],
            [['doc', 'title'], 'string', 'max' => 255],
            [['object_id'], 'exist', 'skipOnError' => true, 'targetClass' => Object::className(), 'targetAttribute' => ['object_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'object_id' => 'Object ID',
            'doc' => 'Документ',
            'docFile' => 'Документ',
            'title' => 'Название документа'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObject()
    {
        return $this->hasOne(Object::className(), ['id' => 'object_id']);
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()){
            $dir = Yii::getAlias('@frontend') . '/web/' . $this->doc;

            if (file_exists($dir)){
                unlink($dir);
            }

            $delDir = Yii::getAlias('@frontend') . '/web/uploads/objects/doc/' . $this->object_id . '/';
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
