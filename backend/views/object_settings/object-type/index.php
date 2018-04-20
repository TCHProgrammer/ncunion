<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\object_settings\ObjectTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Типы объектов';
$this->params['breadcrumbs'][] = [
    'label' => 'Каталог объектов', // название ссылки
    'url' => ['/object'] // сама ссылка
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="object-type-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <?php //ломаные название, проследить ?>
    <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], ]); ?>

    <div class="btn-admin">
        <?= Html::a('Добавить новый тип', ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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

            'title',
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
