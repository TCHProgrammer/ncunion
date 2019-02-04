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

$this->title = 'Отклики на объекты';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="object-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'rowOptions' => function ($model, $key, $index, $grid) {
                return ['data-sortable-id' => $model->user_id];
            },
            'columns' => [
                [
                    'attribute' => 'object.title',
                    'label' => 'Название объекта',
                    'value' => function ($model) {
                        return $model->object->title;
                    }
                ],
                [
                    'attribute' => 'fio',
                    'label' => 'Ф.И.О.',
                    'value' => function ($model) {
                        return Yii::$app->user->id === $model->user->id || Yii::$app->user->can('can_view_investor_info') ? $model->user->last_name . ' ' . $model->user->first_name . ' ' . $model->user->middle_name : $model->user->id;
                    }
                ],
                'object.amount',
                [
                    'attribute' => 'sum',
                    'label' => 'Сумма инвестора',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{acceptButton} {declineButton} {objectView}',
                    'buttons' => [
                        'acceptButton' => function ($url, $model, $key) {
                            if ($model->active) {
                                $button = Html::a('Забрать у инвестора', ['/object/object-finish-back?oId='.$model->object_id.'&uId='.$model->user->id], ['class' => 'btn btn-danger', 'data-confirm' => 'Вы уверены, что хотите забрать объект у инвестора?']);
                            } else {
                                $button = Html::a('Отдать инвестору', ['/object/object-finish?oId=' . $model->object_id . '&uId=' . $model->user->id], ['class' => 'btn btn-success', 'data-confirm' => 'Вы уверены, что хотите отдать объект именно этому инвестору?']);
                            }
                            return $button;
                        },
                        'declineButton' => function ($url, $model, $key) {
                            $button = '';
                            if (!$model->active) {
                                $button = Html::a('Удалить отклик', ['/object/unsubscribe?oId='.$model->object_id.'&uId='.$model->user->id], ['class' => 'btn btn-primary', 'data-confirm' => 'Вы уверены, что хотите удалить отклик?']);
                            }
                            return $button;
                        },
                        'objectView' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/object/view?id='.$model->object_id]);
                        }
                    ]
                ]
            ],
            'options' => [
                'data' => [
                    'sortable-widget' => 1,
                    'sortable-url' => \yii\helpers\Url::toRoute(['sorting']),
                ]
            ],
        ]); ?>
    </div>

    <?php Pjax::end(); ?>
</div>
