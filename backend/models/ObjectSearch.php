<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\object\Object;

/**
 * ObjectSearch represents the model behind the search form of `common\models\object\Object`.
 */
class ObjectSearch extends Object
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type_id', 'status', 'place_km', 'area', 'rooms', 'price_cadastral', 'price_tian', 'price_market', 'price_liquidation'], 'integer'],
            [['title', 'descr', 'address', 'address_map', 'owner'], 'safe'],
            [['amount'], 'number'],
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
        $query = Object::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'descr', $this->descr])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'address_map', $this->address_map])
            ->andFilterWhere(['like', 'owner', $this->owner]);

        return $dataProvider;
    }
}
