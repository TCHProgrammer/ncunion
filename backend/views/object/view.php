<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\object\Object */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Objects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="object-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type_id',
            [
                'attribute' => 'status',
                'value' => function($model){
                    return $model->status ? 'Да' : 'Нет';
                }
            ],
            [
                'attribute' => 'status_object',
                'value' => function($model){
                    return $model->status_object ? 'Сделка открыта' : 'Сделка закрыта';
                }
            ],
            'title',
            'descr:ntext',
            [
                'attribute' => 'place_km',
                'value' => function($model){
                    if ($model->place_km === 0){
                        return 'Москва';
                    }else{
                        return $model->place_km . ' км. от МКАД';
                    }
                }
            ],
            'amount',
            'address',
            'address_map',
            [
                'attribute' => 'area',
                'value' => function($model){
                    return $model->area . ' кв.м';
                }
            ],
            'rooms',
            'owner',
            'price_cadastral',
            'price_tian',
            'price_market',
            'price_liquidation',
            'sticker_id',
            [
                'attribute' => 'created_at',
                'value' => function($model){
                    return Yii::$app->date->month($model->created_at);
                }
            ],

            [
                'attribute' => 'updated_at',
                'value' => function($model){
                    return Yii::$app->date->month($model->updated_at);
                }
            ],

            [
                'attribute' => 'close_at',
                'value' => function($model){
                    return Yii::$app->date->month($model->close_at);
                }
            ],
        ],
    ]) ?>

</div>
