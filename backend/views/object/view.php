<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;
use metalguardian\fotorama\Fotorama;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model common\models\object\Object */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Каталог объектов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="object-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], ]); ?>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(($model->status_object === 0)?'Открыть сделку':'Закрыть сделку', [($model->status_object === 0)?'open':'close', 'id' => $model->id], [
            'class' => ($model->status_object === 0)?'btn btn-success':'btn btn-warning',
            'data' => [
                'confirm' => 'Вы уверанны, что хотите изменит статус сделки?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверанны, что хотите удалить объект?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row">
        <div class="col-lg-6 col-md-6">

            <!-- шкала -->
            <h3>Итоговая сумма инвесторов:</h3>
            <div class="object-progress-striped">
                <div class="left-pr-striped">0</div>
                <div class="center-pr-striped">
                    <div class="progress progress-striped active">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $progress['amount-percent'] ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $progress['amount-percent'] ?>%">
                            <span class="print-amount-striped"><?= $progress['print-amount'] ?>(<?= $progress['amount-percent'] ?>%)</span>
                            </div>
                    </div>
                </div>
                <div class="right-pr-striped"><?= $model->amount ?></div>
            </div>

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
                            switch ($model->status_object){
                                case 2:
                                    return 'Сделка открыта';
                                case 1:
                                    return 'Сделка частично закрыта';
                                default :
                                    return 'Сделка закрыта';
                            }
                        }
                    ],
                    'title',
                    'descr:html',
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
                ],
            ]) ?>
        </div>

        <!-- (правкая колонка) -->
        <div class="col-lg-6 col-md-6">
            <h2>Список откликнувшихся инвесторов</h2>
            <?= ListView::widget([
                'dataProvider' => $usersObjectlist,
                'itemView' => '_listUsers',
                'viewParams' => [
                    'finishObject' => $finishObject,
                    'objectAmount' => $model->amount
                ],
            ]); ?>
        </div>
    </div>

    <?php if (!empty($imgs)) { ?>

        <h3>Фотогалерея</h3>
        <hr>
        <?php
        $fotorama = Fotorama::begin(
            [
                'options' => [
                    'loop' => true,
                    'hash' => true,
                    'ratio' => 800 / 600,
                ],
                'spinner' => [
                    'lines' => 20,
                ],
                'tagName' => 'span',
                'useHtmlData' => false,
                'htmlOptions' => [
                    'class' => 'custom-class',
                    'id' => 'custom-id',
                ],
            ]
        );

        foreach ($imgs as $img) {
            $link = str_replace('admin', '', Url::home(true) . $img->img);
            echo Html::img($link);
        }

        Fotorama::end();
    }
    ?>

    <?php if (!empty($files)){ ?>
        <h3>Документы</h3>
        <hr>
        <?php foreach ($files as $file){ ?>
            <div>
                <?= Html::a($file->title, $file->doc, ['class' => 'form-a-del','download' => true]) . '</p>'; ?>
            </div>
        <?php } ?>
    <?php } ?>

</div>
