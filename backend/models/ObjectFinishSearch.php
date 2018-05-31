<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RoomFinishObject;

/**
 * ObjectFinishSearch represents the model behind the search form of `common\models\RoomFinishObject`.
 */
class ObjectFinishSearch extends RoomFinishObject
{
    /**
     * {@inheritdoc}
     */

    public $object;
    public $user;
    public $manager;

    public function rules()
    {
        return [
            [['object_id', 'user_id', 'manager_id', 'created_at'], 'integer'],
            [['comment', 'object', 'user', 'manager'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'object' => 'Объект',
        ];
    }


    /**
     * {@inheritdoc}
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
        $query = RoomFinishObject::find()->joinWith('objects')->joinWith('users');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

       /* $dataProvider->setSort([
            'attributes' =>[
                'object_id',
                'object' => [
                    'asd' => ['object' => SORT_ASC],
                    'desc' => ['object' => SORT_DESC],
                    'default' => SORT_ASC
                ]
            ]
        ]);*/

        $dataProvider->setSort([
            'attributes' =>[
                'object' => [
                    'asc' => ['title' => SORT_ASC],
                    'desc' => ['title' => SORT_DESC],
                ],
                'user' => [
                    'asc' => ['last_name' => SORT_ASC],
                    'desc' => ['last_name' => SORT_DESC],
                ],
                'manager' => [
                    'asc' => ['last_name' => SORT_ASC],
                    'desc' => ['last_name' => SORT_DESC],
                ],
                'created_at',
            ]
        ]);

        /*$dataProvider->sort->attributes['object_title'] = [
            'asd' => ['title' => SORT_ASC],
            'desc' => ['title' => SORT_DESC],
        ];

        $dataProvider->sort->defaultOrder['object_title'] = SORT_ASC;*/

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'object_id' => $this->object_id,
            'user_id' => $this->user_id,
            'manager_id' => $this->manager_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'object.title', $this->object])
            ->andFilterWhere(['like', 'user.last_name', $this->user])
            ->andFilterWhere(['like', 'user.last_name', $this->manager]);

        return $dataProvider;
    }
}
