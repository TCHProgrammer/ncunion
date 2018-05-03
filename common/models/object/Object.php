<?php

namespace common\models\object;

use Yii;
use common\models\Sticker;
use common\models\object\Attribute;
use common\models\object\Prescribed;
use common\models\object\ObjectImg;
use yii\web\UploadedFile;

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

    public $imgFile;
    public $docFile;
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
            [['docFile'], 'file', 'extensions' => 'txt, pdf, cvg, xlsx, ods, docx'],
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
        ];
    }

    public function beforeSave($insert)
    {

        if($imgs = UploadedFile::getInstances($this, 'imgFile')){
            foreach ($imgs as $img){
                $dir = Yii::getAlias('@frontend/web/uploads/objects/') . $this->id . '/';

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
        return $this->hasMany(ObjectImg::className(), ['object_id' => 'id']);
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
