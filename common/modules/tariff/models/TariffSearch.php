<?php

namespace common\modules\tariff\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\tariff\models\Tariff;

/**
 * TariffSearch represents the model behind the search form of `common\modules\tariff\models\Tariff`.
 */
class TariffSearch extends Tariff
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'days', 'status', 'discount_id'], 'integer'],
            [['price'], 'number'],
            [['img', 'title', 'top_title', 'bot_title', 'descr'], 'safe'],
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
        $query = Tariff::find();

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
            'days' => $this->days,
            'price' => $this->price,
            'status' => $this->status,
            'discount_id' => $this->discount_id,
        ]);

        $query->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'top_title', $this->top_title])
            ->andFilterWhere(['like', 'bot_title', $this->bot_title])
            ->andFilterWhere(['like', 'descr', $this->descr]);

        return $dataProvider;
    }
}
