<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Клиенты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-model-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a('Зарегистрировать нового клиента', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered table-hover-gray'
        ],
        'rowOptions' =>function($model){
            return [
                'onclick' => 'window.location = "' . Url::to(['update', 'id' => $model->id]) . '"',
                'style' => 'cursor:pointer'
            ];
        },
        'columns' => [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
            ],
            [
                'attribute' => 'id',
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['class' => 'text-center'],
                'options' => [
                    'style' => 'width:35px',
                ]
            ],
            'last_name',
            'first_name',
            'middle_name',
            'email:email',
            'phone',
            //'company_name',
            //'check_email:email',
            //'check_phone',
            [
                'filter' => false,
                'attribute' => 'created_at',
                'format' => ['datetime', 'php:d.m.Y в h:i:s'],
            ],
            [
                'filter' => false,
                'attribute' => 'updated_at',
                'format' => ['datetime', 'php:d.m.Y в h:i:s'],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
