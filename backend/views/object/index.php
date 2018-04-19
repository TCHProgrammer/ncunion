<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ObjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Каталог объектов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="object-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <p>
        <div class="btn-group">

            <?= Html::a('Создать объект', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="btn-group">
            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Общие настройки <span class="caret"></span></button>
            <ul class="dropdown-menu">
                <li><a href="#">Действие</a></li>
                <li><a href="#">Другое действие</a></li>
                <li><a href="#">Еще и еще</a></li>
                <li class="divider"></li>
                <li><a href="#">Отделенный пункт</a></li>
            </ul>
        </div>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered table-hover-gray'
        ],
        'rowOptions' =>function($model){
            return [
                'onclick' => 'window.location = "' . Url::to(['view', 'id' => $model->id]) . '"',
                'style' => 'cursor:pointer'
            ];
        },
        'columns' => [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'options' => ['style' => 'width:35px'],
                'contentOptions' => ['class' => 'text-center'],
            ],

            [
                'attribute' => 'id',
                'options' => ['style' => 'width:31px;'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],

            [
                'attribute' => 'type_id',
                'filter' => [
                    1 => 'Квартира',
                    2 => 'Дом',
                    3 => 'Коммерция',
                ],
                'headerOptions' => ['class' => 'text-center'],
                'options' => ['style' => 'width:140px;'],
                'value' => function($model){
                    switch ($model->type_id) {
                        case 1:
                            return 'Квартира';
                            break;
                        case 2:
                            return 'Дом';
                            break;
                        case 3:
                            return 'Коммерция';
                            break;
                    }
                }
            ],

            [
                'attribute' => 'status',
                'filter' => [
                    1 => 'Да',
                    0 => 'Нет',
                ],
                'headerOptions' => ['class' => 'text-center'],
                'options' => ['style' => 'width:110px;'],
                'value' => function($model){
                    return $model->status ? 'Да' : 'Нет';
                }
            ],

            'title',

            [
                'attribute' => 'place_km',
                'filter' => [
                    1 => 'Квартира',
                    2 => 'Дом',
                    3 => 'Коммерция',
                ],
                'headerOptions' => ['class' => 'text-center'],
                'options' => ['style' => 'width:140px;'],
                'value' => function($model){
                    switch ($model->type_id) {
                        case 1:
                            return 'Квартира';
                            break;
                        case 2:
                            return 'Дом';
                            break;
                        case 3:
                            return 'Коммерция';
                            break;
                    }
                }
            ],
            //'amount',
            //'address',
            //'address_map',
            //'area',
            //'rooms',
            //'owner',
            //'price_cadastral',
            //'price_tian',
            //'price_market',
            //'price_liquidation',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'options' => ['style' => 'width:35px'],
                'contentOptions' => ['class' => 'text-center'],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
