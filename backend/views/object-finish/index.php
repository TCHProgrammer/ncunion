<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ObjectFinishSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Завершённые объекты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="room-finish-object-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'object',
                'value' => function($data){
                    return Html::a(Html::encode($data->objects->title), Url::to(['/object/view', 'id' => $data->objects->id]));
                },
                'format' => 'raw'
            ],

            [
                'attribute' => 'user',
                'value' => function($data){
                    return Html::a(Html::encode($data->users->last_name), Url::to(['/user/view', 'id' => $data->users->id]));
                },
                'format' => 'raw'
            ],

            /*[
                'attribute' => 'manager',
                'value' => function($data){
                    if(is_null($data->manager_id)){
                        return '-';
                    }else{
                        return Html::a(Html::encode($data->users->last_name), Url::to(['/users/view', 'id' => $data->users->id]));
                        //return Html::a(Html::encode($data->user->last_name . ' ' . $data->user->first_name  . ' ' . $data->user->middle_name), Url::to(['/users/view', 'id' => $data->user->id]));
                    }
                },
                'format' => 'raw'
            ],*/

            'created_at:datetime',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'options' => ['style' => 'width:35px'],
                'contentOptions' => ['class' => 'text-center'],
            ],

        ],
    ]); ?>
</div>
