<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\object\Object;

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
 */
class ObjectSearch extends Object
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type_id', 'status', 'place_km', 'area', 'rooms', 'price_cadastral', 'price_tian', 'price_market', 'price_liquidation', 'status_object', 'sticker_id', 'created_at', 'updated_at', 'close_at'], 'integer'],
            [['title', 'descr', 'address', 'address_map', 'owner'], 'safe'],
            [['amount'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => 'Тип объекта',
            'status' => 'Активность',
            'title' => 'Название',
            'descr' => 'Описание',
            'place_km' => 'Удалённость',
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

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        //данные из паспорта
        //$this->type_id = 2;

        $query = Object::find()
            ->andWhere(['status' => 1])
            ->select([Object::tableName().'.id'])
            ->orderBy('status_object DESC')
            ->joinWith('objectImgs')
            ->joinWith('objectCheckbox');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => Object::find()->where(['in', 'id', $query]),
            'pagination' => [
                'pageSize' => 4,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'type_id' => $this->type_id,
            'status' => $this->status,
            'place_km' => $this->place_km,
            'amount' => $this->amount,
            'area' => $this->area,
            'rooms' => $this->rooms,
            'price_cadastral' => $this->price_cadastral,
            'price_tian' => $this->price_tian,
            'price_market' => $this->price_market,
            'price_liquidation' => $this->price_liquidation,
            'status_object' => $this->status_object,
            'sticker_id' => $this->sticker_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'close_at' => $this->close_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'descr', $this->descr])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'address_map', $this->address_map])
            //->andFilterWhere(['like', 'objectCheckbox.group_id', 19])
            ->andFilterWhere(['like', 'owner', $this->owner]);

        return $dataProvider;
    }
}
