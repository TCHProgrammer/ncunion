<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\modules\tariff\models\TariffDiscount;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\tariff\models\TariffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tariffs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tariff-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать тариф', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Добавить скидку', ['discount'], ['class' => 'btn btn-success btn-indents-right']) ?>
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

            'days',
            'price',

            [
                'attribute' => 'discount_id',
                'filter' => [
                    1 => '%',
                    2 => '-'
                ],
                'headerOptions' => ['class' => 'text-center'],
                'options' => ['style' => 'width:110px;'],
                'value' => function($model){
                    $rez = TariffDiscount::find()->select(['title'])->where(['id' => $model->discount_id])->one();
                    if (isset($rez)){
                        return $rez->title;
                    }else{
                        return 'Нет';
                    }
                }
            ],

            //'img',
            //'title',
            //'top_title',
            //'bot_title',
            //'descr:ntext',

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
