<?php

namespace common\models\object;

use Yii;
use common\models\Sticker;
use common\models\object\Attribute;
use common\models\object\Prescribed;
use common\models\object\ObjectImg;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;
use common\models\object\ObjectFile;

/**
 * This is the model class for table "object".
 *
 * @property int $id
 * @property int $type_id
 * @property int $status
 * @property string $title
 * @property string $descr
 * @property int $place_km
 * @property string $amount
 * @property string $address
 * @property string $address_map
 * @property int $area
 * @property int $rooms
 * @property string $owner
 * @property int $price_cadastral
 * @property int $price_tian
 * @property int $price_market
 * @property int $price_liquidation
 * @property int $created_at
 * @property int $updated_at
 * @property int $close_at
 * @property int $status_object
 * @property int $sticker_id
 *
 * @property ObjectType $type
 * @property ObjectAttribute[] $objectAttributes
 * @property ObjectFile[] $objectFiles
 * @property ObjectImg[] $objectImgs
 * @property ObjectPrescribed[] $objectPrescribeds
 */
class Object extends \yii\db\ActiveRecord
{

    public $amountRemained;
    public $imgFile;
    //public $docFile;
    const file_name_length = 8;

    public static function tableName()
    {
        return 'object';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['noticesArray'], 'safe'],
            [['imgFile'], 'file', 'extensions' => 'png, jpg'],
            //[['docFile'], 'file', 'extensions' => 'png, txt, pdf, cvg, xlsx, ods, docx'],
            [['created_at'], 'default', 'value'=> time()],
            [['updated_at'], 'default', 'value'=> time()],
            [['type_id', 'title', 'created_at', 'updated_at'], 'required'],
            [['type_id', 'status', 'place_km', 'area', 'rooms', 'price_cadastral', 'price_tian', 'price_market', 'price_liquidation', 'status_object', 'sticker_id', 'created_at', 'updated_at', 'close_at'], 'integer'],
            [['created_at', 'updated_at'], 'default', 'value' => time()],
            [['descr'], 'string'],
            [['amount'], 'number'],
            [['title', 'address', 'address_map', 'owner'], 'string', 'max' => 255],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ObjectType::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => 'Тип объекта',
            'status' => 'Активность',
            'title' => 'Название',
            'descr' => 'Описание',
            'place_km' => 'Удалённость (0 - Москва, больше 1 км от МКАД)',
            'amount' => 'Требуемая сумма',
            'address' => 'Адресс',
            'address_map' => 'Адрес на карте',
            'area' => 'Метраж',
            'rooms' => 'Комнаты',
            'noticesArray' => 'Прописанные:',
            'owner' => 'Правоустановка',
            'price_cadastral' => 'Кадастровая стоимость',
            'price_tian' => 'ЦИАН',
            'price_market' => 'Рыночная стоимость',
            'price_liquidation' => 'Ликвидационная  стоимость',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата последнего изменения',
            'close_at' => 'Дата закрытия сделки',
            'status_object' => 'Статус сделки',
            'sticker_id' => 'Стикер',
            'amountRemained' => 'Нехватает до закрытия'
        ];
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()){

            /* удаление файлов у объекта */
            $listFiles = ObjectFile::find()->where(['object_id' => $this->id])->all();

            if ($listFiles){
                foreach ($listFiles as $file){
                    $dir = Yii::getAlias('@frontend') . '/web/' . $file->doc;
                    unlink($dir);
                }

                $delDirFile = Yii::getAlias('@frontend') . '/web/uploads/objects/doc/' . $this->id . '/';

                $arrFiles = scandir($delDirFile);
                if (is_null($arrFiles[2])){
                    rmdir($delDirFile);
                }
            }

            /* удаление изображений у объекта */
            $listImg = ObjectImg::find()->where(['object_id' => $this->id])->all();

            if ($listImg){
                foreach ($listImg as $img){
                    $dir = Yii::getAlias('@frontend') . '/web/' . $img->img;
                    unlink($dir);
                }

                $delDirImg = Yii::getAlias('@frontend') . '/web/uploads/objects/img/' . $this->id . '/';

                $arrImg = scandir($delDirImg);
                if (is_null($arrImg[2])){
                    rmdir($delDirImg);
                }
            }

            return true;
        }else{
            return false;
        }
    }

    public function beforeSave($insert)
    {

        if($filesImg = UploadedFile::getInstances($this, 'imgFile')){

            foreach ($filesImg as $img){

                $dir = Yii::getAlias('@uploads/objects/img/' . $this->id . '/');

                /*if(file_exists($dir)){
                    unlink(Yii::getAlias($dir . $img->name));
                    if(!file_exists($dir)) {
                        rmdir($dir);
                    }
                }*/

                if (!is_dir($dir)){
                    FileHelper::createDirectory($dir, 0777);
                }

                $this->imgFile = strtotime('now') . '_'
                    . Yii::$app->getSecurity()->generateRandomString(8)
                    . '.' . $img->getExtension();

                $fileName = $dir . $this->imgFile;

                $model = new ObjectImg();
                $model->object_id = $this->id;
                $model->img = 'uploads/objects/img/' . $this->id . '/' . $this->imgFile;

                $img->saveAs($fileName);

                $model->save();

//                $imgs->save($dir . $this->imgFile);

                //if (file)
                    /*https://www.youtube.com/watch?v=0SC7up01NSA*/

            }
        }

        return parent::beforeSave($insert);
    }

    public function updateDate(){
        return $this->updated_at = time();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ObjectType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectAttributes()
    {
        return $this->hasMany(ObjectAttribute::className(), ['object_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectFiles()
    {
        return $this->hasMany(ObjectFile::className(), ['object_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectImgs()
    {
        return $this->hasMany(ObjectImg::className(), ['object_id' => 'id'])->orderBy('sort');
    }

    public function getImgLists(){
        return ArrayHelper::getColumn($this->objectImgs, 'imageUrl');
    }

    public function getImgLinkData(){

        $arr = ArrayHelper::toArray($this->objectImgs, [
            ObjectImg::className() => [
                'caption' => 'img',
                'key' => 'id'
            ],
        ]);

        $i = 0;
        foreach ($arr as $item){

            $arr[$i]['caption'] = substr(strrchr($item['caption'], "/"), 1);
            $i++;
        }
        return $arr;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectPrescribeds()
    {
        return $this->hasMany(ObjectPrescribed::className(), ['object_id' => 'id']);
    }

    public function getAttribs()
    {
        return $this->hasMany(Attribute::className(), ['id' => 'attribute_id'])->viaTable('{{%object_attribute}}', ['object_id' => 'id']);
    }

    public function getStickers()
    {
        return $this->hasOne(Sticker::className(), ['id' => 'sticker_id']);
    }

    public function getPrescribed() //object_prescribed
    {
        return $this->hasMany(Prescribed::className(), ['id' => 'prescribed_id'])->viaTable('{{%object_prescribed}}', ['object_id' => 'id']);
    }

    private $_noticesArray;

    public function getNoticesArray()
    {
        if ($this->_noticesArray === null) {
            $this->_noticesArray = $this->getPrescribed()->select('id')->column();
        }
        return $this->_noticesArray;
    }

    public function setNoticesArray($value){
        return $this->_noticesArray = (array)$value;
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->updateNotices();
        parent::afterSave($insert, $changedAttributes);
    }

    private function updateNotices()
    {
        $currentNoticeIds = $this->getPrescribed()->select('id')->column();
        $newNoticeIds = $this->getNoticesArray();

        foreach (array_filter(array_diff($newNoticeIds, $currentNoticeIds)) as $noticeId) {
            if ($notice = Prescribed::find()->where(['id' => $noticeId])->one()) {
                $this->link('prescribed', $notice);
            }
        }

        foreach (array_filter(array_diff($currentNoticeIds, $newNoticeIds)) as $noticeId) {
            if ($notice = Prescribed::find()->where(['id' => $noticeId])->one()) {
                $this->unlink('prescribed', $notice, true);
            }
        }
    }
}