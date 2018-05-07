<?php

namespace common\models\object;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "object_img".
 *
 * @property int $object_id
 * @property string $img
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
            [['imgFile'], 'image'],
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
