<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;
use common\models\object\ObjectType;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\object_attribute\AttributeCheckboxSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Дополнительные атрибуты: список';
$this->params['breadcrumbs'][] = [
    'label' => 'Каталог объектов',
    'url' => ['/object']
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attribute-checkbox-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], ]); ?>

    <p>
        <?= Html::a('Добавить новый атрибут', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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

            [
                'filter' => ArrayHelper::map(ObjectType::find()->all(), 'id', 'title'),
                'attribute' => 'type_id',
                'value' => function($model){
                    $rez = ObjectType::find()->select(['title'])->where(['id' => $model->type_id])->one();
                    return $rez->title;
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'options' => ['style' => 'width:35px'],
                'contentOptions' => ['class' => 'text-center'],
            ],
        ],
    ]); ?>
</div>
