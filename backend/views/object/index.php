<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\object\ObjectType;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ObjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Каталог объектов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="object-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <div class="btn-admin">
        <div class="btn-group">

            <?= Html::a('Создать объект', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="btn-group">
            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Общие настройки<span class="caret"></span></button>
            <ul class="dropdown-menu">
                <li><a href="<?= Url::toRoute(['object_settings/object-type']) ?>">Типы объектов</a></li>
                <li><a href="<?= Url::toRoute(['object_settings/prescribed']) ?>">Прописанные</a></li>
                <li><a href="<?= Url::toRoute(['object_settings/sticker']) ?>">Стикеры</a></li>
                <li><a href="<?= Url::toRoute(['object_settings/form-participation']) ?>">Форма участия</a></li>
            </ul>
        </div>
        <div class="btn-group">
            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Дополнительные атрибуты<span class="caret"></span></button>
            <ul class="dropdown-menu">
                <li><a href="<?= Url::toRoute(['object_attribute/attribute']) ?>">Строчка</a></li>
                <li><a href="<?= Url::toRoute(['object_attribute/attribute-checkbox']) ?>">Список (checkbox)</a></li>
                <li><a href="<?= Url::toRoute(['object_attribute/attribute-radio']) ?>">Переключатель (radio)</a></li>
            </ul>
        </div>
    </div>

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
                'filter' => ArrayHelper::map(ObjectType::find()->all(), 'id', 'title'),
                'headerOptions' => ['class' => 'text-center'],
                'options' => ['style' => 'width:140px;'],
                'value' => function($model){
                    $rez = ObjectType::find()->select(['title'])->where(['id' => $model->type_id])->one();
                    return $rez->title;
                }
            ],
            /*
             *   [
                'attribute' => 'type.title',
                'filter' => ArrayHelper::map(ObjectType::find()->all(), 'id', 'title'),
                'headerOptions' => ['class' => 'text-center'],
                'options' => ['style' => 'width:140px;'],
            ],
             */

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

            [
                'attribute' => 'status_object',
                'filter' => [
                    1 => 'Сделка открыта',
                    0 => 'Сделка закрыта',
                ],
                'headerOptions' => ['class' => 'text-center'],
                'options' => ['style' => 'width:170px;'],
                'value' => function($model){
                    return $model->status_object ? 'Сделка открыта' : 'Сделка закрыта';
                }
            ],

            'title',

            [
                'attribute' => 'place_km',
                'label' => 'Удалённость',
                'headerOptions' => ['class' => 'text-center'],
                'options' => ['style' => 'width:140px;'],
                'value' => function($model){
                    if ($model->place_km === 0) {
                        return 'Москва';
                    }else{
                        return $model->place_km . ' км от МКАД';
                    }
                }
            ],

            //'address',
            //'address_map',

            [
                'attribute' => 'amount',
                'options' => ['style' => 'width:150px;'],
                'format' => ['decimal', 0],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],

            [
                'attribute' => 'area',
                'options' => ['style' => 'width:95px;'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function($model){
                    if ($model->area){
                        return $model->area . ' м²';
                    }
                }
            ],

            [
                'attribute' => 'rooms',
                'options' => ['style' => 'width:95px;'],
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],

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
