<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\modules\rbac\models\AuthItem;

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
        <?= Html::a('Зарегистрировать нового клиента', ['create-user'], ['class' => 'btn btn-success']) ?>
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
            ],
            [
                'attribute' => 'id',
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['class' => 'text-center'],
                'options' => [
                    'style' => 'width:35px',
                ]
            ],
            //'subscribe_dt',
            'last_name',
            'first_name',
            'middle_name',

            [
                'filter' => true,
                'attribute' => 'role',
                'value' => function($model){
                    return (AuthItem::find()->select('description')->where(['name' => $model->roles[0]->item_name])->one())->description;
                }
            ],

            'email:email',
            'phone',

            [
                'filter' => false,
                'attribute' => 'created_at',
                'value' => function($model){
                    return Yii::$app->date->month($model->created_at);
                }
            ],

            [
                'filter' => false,
                'attribute' => 'updated_at',
                'value' => function($model){
                    return Yii::$app->date->month($model->updated_at);
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
