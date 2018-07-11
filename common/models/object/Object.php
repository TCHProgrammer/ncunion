<?php

namespace common\models\object;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;
use common\models\Tag;
use common\models\ObjectTag;
use common\models\object\Confidence;

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
 * @property int $order
 * @property int $rate
 * @property int $term
 * @property int $schedule_payments
 * @property int $nks
 *
 * @property ObjectType $type
 * @property ObjectAttribute[] $objectAttributes
 * @property ObjectFile[] $objectFiles
 * @property ObjectImg[] $objectImgs
 * @property ObjectTag[] $objectTags
 */
class Object extends \yii\db\ActiveRecord
{
    public $amountRemained;
    public $imgFile;
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
            [['tagsArray', 'confArray'], 'safe'],
            [['imgFile'], 'file', 'extensions' => 'png, jpg'],
            //[['docFile'], 'file', 'extensions' => 'png, txt, pdf, cvg, xlsx, ods, docx'],
            [['created_at'], 'default', 'value'=> time()],
            [['updated_at'], 'default', 'value'=> time()],
            [['order'], 'default', 'value' => 0],
            [['type_id', 'status', 'place_km', 'rooms', 'price_cadastral', 'price_tian', 'price_market', 'price_liquidation', 'status_object', 'created_at', 'updated_at', 'close_at', 'rate', 'term', 'schedule_payments', 'nks'], 'integer'],
            [['descr'], 'string'],
            [['amount', 'area'], 'number'],
            [['type_id', 'title', 'created_at', 'updated_at', 'order', 'descr', 'amount', 'place_km', 'area', 'rooms', 'rate', 'term', 'schedule_payments'], 'required'],
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
            'tagsArray' => 'Теги',
            'owner' => 'Правоустановка',
            'price_cadastral' => 'Кадастровая стоимость',
            'price_tian' => 'ЦИАН',
            'price_market' => 'Рыночная стоимость',
            'price_liquidation' => 'Ликвидационная  стоимость',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата последнего изменения',
            'close_at' => 'Дата закрытия сделки',
            'status_object' => 'Статус сделки',
            'amountRemained' => 'Нехватает до закрытия',
            'order' => 'Сортировка',
            'rate' => 'Ставка',
            'term' => 'Срок',
            'schedule_payments' => 'График платежей',
            'nks' => 'НКС'
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
                    if (file_exists($dir)){
                        unlink($dir);
                    }
                }

                $delDirFile = Yii::getAlias('@frontend') . '/web/uploads/objects/doc/' . $this->id . '/';

                $arrFiles = scandir($delDirFile);
                if (!isset($arrFiles[2])){
                    rmdir($delDirFile);
                }
            }

            /* удаление изображений у объекта */
            $listImg = ObjectImg::find()->where(['object_id' => $this->id])->all();

            if ($listImg){
                foreach ($listImg as $img){
                    $dir = Yii::getAlias('@frontend') . '/web/' . $img->img;
                    if (file_exists($dir)){
                        unlink($dir);
                    }
                }

                $delDirImg = Yii::getAlias('@frontend') . '/web/uploads/objects/img/' . $this->id . '/';

                $arrImg = scandir($delDirImg);
                if (!isset($arrImg[2])){
                    rmdir($delDirImg);
                }
            }

            return true;
        }else{
            return false;
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->updateTags();
        $this->updateConf();
        parent::afterSave($insert, $changedAttributes);
    }

    public function beforeSave($insert)
    {

        if($filesImg = UploadedFile::getInstances($this, 'imgFile')){

            foreach ($filesImg as $img){

                $dir = Yii::getAlias('@uploads/objects/img/' . $this->id . '/');

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

    public function getObjectValues()
    {
        return $this->hasMany(ObjectAttribute::className(), ['object_id' => 'id']);
    }

    public function getObjectCheckboxes()
    {
        return $this->hasMany(ObjectAttributeCheckbox::className(), ['object_id' => 'id']);
    }

    public function getObjectRadios()
    {
        return $this->hasMany(ObjectAttributeRadio::className(), ['object_id' => 'id']);
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
    public function getObjectTags()
    {
        return $this->hasMany(ObjectTag::className(), ['object_id' => 'id']);
    }

    public function getAttribs()
    {
        return $this->hasMany(Attribute::className(), ['id' => 'attribute_id'])->viaTable('{{%object_attribute}}', ['object_id' => 'id']);
    }

    public function getTag()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('{{%object_tag}}', ['object_id' => 'id']);
    }

    public function getConfidence()
    {
        return $this->hasMany(Confidence::className(), ['id' => 'confidence_id'])
            ->viaTable('{{%confidence_object}}', ['object_id' => 'id']);
    }

    /* сохраниение тегов */
    private $_tagsArray;

    public function getTagsArray()
    {
        if ($this->_tagsArray === null) {
            $this->_tagsArray = $this->getTag()->select('id')->column();
        }
        return $this->_tagsArray;
    }

    public function setTagsArray($value){
        return $this->_tagsArray = (array)$value;
    }

    private function updateTags()
    {
        $currentNoticeIds = $this->getTag()->select('id')->column();
        $newNoticeIds = $this->getTagsArray();

        foreach (array_filter(array_diff($newNoticeIds, $currentNoticeIds)) as $noticeId) {
            if ($notice = Tag::find()->where(['id' => $noticeId])->one()) {
                $this->link('tag', $notice);
            }
        }

        foreach (array_filter(array_diff($currentNoticeIds, $newNoticeIds)) as $noticeId) {
            if ($notice = Tag::find()->where(['id' => $noticeId])->one()) {
                $this->unlink('tag', $notice, true);
            }
        }
    }

    private $_confArray;

    public function getConfArray()
    {
        if ($this->_confArray === null) {
            $this->_confArray = $this->getConfidence()->select('id')->column();
        }
        return $this->_confArray;
    }

    public function setConfArray($value){
        return $this->_confArray = (array)$value;
    }

    private function updateConf()
    {
        $allTagsIds = $this->getConfidence()->select('id')->column();
        $newTagsIds = $this->getConfArray();

        foreach (array_filter(array_diff($newTagsIds, $allTagsIds)) as $noticeId) {
            if ($tag = Confidence::find()->where(['id' => $noticeId])->one()) {
                $this->link('confidence', $tag);
            }
        }

        foreach (array_filter(array_diff($allTagsIds, $newTagsIds)) as $noticeId) {
            if ($tag = Confidence::find()->where(['id' => $noticeId])->one()) {
                $this->unlink('confidence', $tag, true);
            }
        }
    }
}
