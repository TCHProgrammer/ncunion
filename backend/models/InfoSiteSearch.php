<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InfoSite;

/**
 * InfoSiteSearch represents the model behind the search form of `common\models\InfoSite`.
 */
class InfoSiteSearch extends InfoSite
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'bot_title', 'descr', 'letter_email', 'letter_phone', 'supp_email', 'supp_phone'], 'safe'],
            [['id'], 'integer'],
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
        $query = InfoSite::find();

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
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'bot_title', $this->bot_title])
            ->andFilterWhere(['like', 'descr', $this->descr])
            ->andFilterWhere(['like', 'letter_email', $this->letter_email])
            ->andFilterWhere(['like', 'letter_phone', $this->letter_phone])
            ->andFilterWhere(['like', 'supp_email', $this->supp_email])
            ->andFilterWhere(['like', 'supp_phone', $this->supp_phone]);

        return $dataProvider;
    }
}
