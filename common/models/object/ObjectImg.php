<?php

namespace common\models\object;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "object_img".
 *
 * @property int $object_id
 * @property string $img
 * @property string $sort
 *
 * @property Object $object
 */
class ObjectImg extends \yii\db\ActiveRecord
{

    public $imgFile;

    public static function tableName()
    {
        return 'object_img';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['object_id', 'sort'], 'integer'],
            [['sort'], 'default', 'value' => function($model){
                $count = ObjectImg::find()->count();
                return ($count > 0 ) ? $count++ : 0;
            }],
            [['imgFile'], 'image', 'extensions' => 'jpg, png'],
            [['img'], 'string', 'max' => 255],
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
            'img' => 'Изображение',
        ];
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()){
            $dir = Yii::getAlias('@frontend') . '/web/' . $this->img;

            unlink($dir);

            ObjectImg::updateAllCounters(
                ['sort' => -1], ['and', ['object_id' => $this->object_id], ['>', 'sort', $this->sort]]
            );

            $delDir = Yii::getAlias('@frontend') . '/web/uploads/objects/img/' . $this->object_id . '/';
            $arrImg = scandir($delDir);
            if (is_null($arrImg[2])){
                rmdir($delDir);
            }

            return true;
        }else{
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObject()
    {
        return $this->hasOne(Object::className(), ['id' => 'object_id']);
    }

    public function getImageUrl(){
        if ($this->img){
            $path = str_replace('admin', '', Url::home(true)) . $this->img;
        }else{
            $path = str_replace('admin', '', Url::home(true)) . 'uploads/objects/img/no_photo.png';
        }

        return $path;
    }
}
