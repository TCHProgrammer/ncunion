<?php

namespace frontend\models;

use common\models\object\ObjectAttributeRadio;
use common\models\passport\UserPassport;
use common\models\UserModel;
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
 * @property int $amount_min
 * @property int $amount_max
 * @property int $area_min
 * @property int $area_max
 * @property int $rooms_min
 * @property int $rooms_max
 *
 */
class ObjectSearch extends Object
{
    public $amount_min;
    public $amount_max;
    public $area_min;
    public $area_max;
    public $rooms_min;
    public $rooms_max;

    public function rules()
    {
        return [
            [['id', 'type_id', 'status', 'place_km', 'area', 'rooms', 'price_cadastral', 'price_tian', 'price_market', 'price_liquidation',
              'amount_min', 'amount_max', 'area_min', 'area_max', 'rooms_min', 'rooms_max'], 'integer'],
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
            'tagsArray' => 'Теги',
            'owner' => 'Правоустановка',
            'price_cadastral' => 'Кадастровая стоимость',
            'price_tian' => 'ЦИАН',
            'price_market' => 'Рыночная стоимость',
            'price_liquidation' => 'Ликвидационная  стоимость',
            'amount_min' => 'Мин стоимость',
            'amount_max' => 'Макс стоимость',
            'area_min' => 'Мин площадь',
            'area_max' => 'Макс площадь',
            'rooms_min' => 'Мин колличество комнат',
            'rooms_max' => 'Макс колличество комнат',
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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
        /*$user = UserModel::findOne(Yii::$app->user->id);
        $passport = UserPassport::findOne($user->user_passport_id);
        $this->type_id = $passport->type_id;
        $this->area = $passport->area;
        $this->rooms = $passport->rooms;*/

        $query = Object::find()
            ->alias('o')
            ->andWhere(['status' => 1])
            ->andWhere(['!=', 'status_object', 0])
            ->orderBy(['order' => SORT_ASC, 'created_at' => SORT_DESC])
            ->addGroupBy('o.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 4,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'type_id' => $this->type_id,
            'amount' => $this->amount,
            //'area' => $this->area,
            //'rooms' => $this->rooms,
            'price_cadastral' => $this->price_cadastral,
            'price_tian' => $this->price_tian,
            'price_market' => $this->price_market,
            'price_liquidation' => $this->price_liquidation,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['between', 'amount', $this->amount_min, $this->amount_max])
            ->andFilterWhere(['between', 'area', $this->area_min, $this->area_max])
            ->andFilterWhere(['between', 'rooms', $this->rooms_min, $this->rooms_max]);

        if ($this->place_km) {
            if ($this->place_km == 0){
                $query->andFilterWhere(['place_km' => $this->place_km]);
            }else{
                $query->andFilterWhere(['<=', 'place_km', $this->place_km])
                    ->andFilterWhere(['!=', 'place_km', 0]);
            }

        }

        if (isset($params['GroupCheckboxes'][$this->type_id])){
            foreach ($params['GroupCheckboxes'][$this->type_id] as $attribute => $groups){
                $query ->joinWith('objectCheckboxes oac' . $attribute);
                $filter = ['or'];
                foreach ($groups as $group){
                    $filter[] = ['oac' . $attribute . '.group_id' => (int)$group];

                }
                $query->andFilterWhere($filter);
            };
        }

        if (isset($params['GroupRadios'][$this->type_id])){
            foreach ($params['GroupRadios'][$this->type_id] as $attribute => $groups){
                $query ->joinWith('objectRadios oar' . $attribute);
                $filter = ['or'];
                foreach ($groups as $group){
                    $filter[] = ['oar' . $attribute . '.group_id' => (int)$group];

                }
                $query->andFilterWhere($filter);
            };
        }

        return $dataProvider;
    }

}
