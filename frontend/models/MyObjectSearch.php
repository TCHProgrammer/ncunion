<?php

namespace frontend\models;

use common\models\object\ObjectAttributeRadio;
use common\models\passport\UserPassport;
use common\models\RoomObjectUser;
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
 */
class MyObjectSearch extends Object
{

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
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Object::find()
            ->alias('o')
            ->andWhere(['status' => 1])
            ->orderBy(['order' => SORT_ASC, 'created_at' => SORT_DESC])
            ->addGroupBy('o.id');

        $userObjs = RoomObjectUser::find()
            ->select('object_id')
            ->where(['user_id' => Yii::$app->user->id])
            ->all();

        if (!empty($userObjs)){
            foreach ($userObjs as $item){
                $arrObj[] = $item->object_id;
            }
        }else{
            $arrObj = [];
        }


        $query->andWhere(['id' => $arrObj]);

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

        return $dataProvider;
    }

}
