<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\object\Object;

/**
 * ObjectSearch represents the model behind the search form of `common\models\object\Object`.
 */
class ObjectSearch extends Object
{
    public $broker_full_name;
    public $broker_phone;
    public $broker_email;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type_id', 'status', 'place_km', 'rooms', 'price_cadastral', 'price_tian', 'price_market', 'price_liquidation', 'status_object', 'rate', 'term', 'schedule_payments'], 'integer'],
            [['title', 'descr', 'address', 'address_map', 'owner'], 'safe'],
            [['broker_full_name', 'broker_email'], 'string'],
            [['amount', 'area', 'broker_phone'], 'number'],
            ['broker_full_name', 'filter', 'filter'=>'strtolower'],
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
        $userTable = User::tableName();
        $query = Object::find()->leftJoin($userTable, "{$userTable}.id = broker_id")->orderBy(['order' => SORT_ASC, 'created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => ['']
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
            'status_object' => $this->status_object
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'descr', $this->descr])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'address_map', $this->address_map])
            ->andFilterWhere(['like', 'owner', $this->owner])
            ->andFilterWhere(['like', "CONCAT(LOWER({$userTable}.last_name), ' ', LOWER({$userTable}.first_name), ' ', LOWER({$userTable}.middle_name))", $this->broker_full_name])
            ->andFilterWhere(['like', $userTable.'.email', $this->broker_email])
            ->andFilterWhere(['like', $userTable.'.phone', $this->broker_phone]);

        return $dataProvider;
    }
}
