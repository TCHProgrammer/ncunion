<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;
use metalguardian\fotorama\Fotorama;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\helpers\ArrayHelper;
use common\models\object\ObjectType;

/* @var $this yii\web\View */
/* @var $model common\models\object\Object */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Каталог объектов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$isCommerce = ObjectType::find()->where(['title' => 'Коммерция', 'id' => $model->type_id])->one();
$isCommerce = isset($isCommerce);
?>
<div class="object-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],]); ?>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(($model->status_object === 0) ? 'Открыть сделку' : 'Закрыть сделку', [($model->status_object === 0) ? 'open' : 'close', 'id' => $model->id], [
            'class' => ($model->status_object === 0) ? 'btn btn-success' : 'btn btn-warning',
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
        <?= Html::a('Просмотр', Url::to(['../../catalog/view', 'id' => $model->id]), ['class' => 'btn btn-success']); ?>

    </p>

    <div class="row">
        <div class="col-lg-6 col-md-6">

            <!-- доверие объекту -->
            <h3>Доверие объекта:</h3>
            <p>Доверие объекта составяент <?= $confObj ?>%</p>

            <!-- шкала -->
            <h3>Итоговая сумма инвесторов:</h3>
            <div class="object-progress-striped">
                <div class="left-pr-striped">0</div>
                <div class="center-pr-striped">
                    <div class="progress progress-striped active">
                        <div class="progress-bar progress-bar-success" role="progressbar"
                             aria-valuenow="<?= $progress['amount-percent'] ?>" aria-valuemin="0" aria-valuemax="100"
                             style="width: <?= $progress['amount-percent'] ?>%">
                            <span class="print-amount-striped"><?= $progress['print-amount'] ?>
                                (<?= $progress['amount-percent'] ?>%)</span>
                        </div>
                    </div>
                </div>
                <div class="right-pr-striped"><?= $model->amount ?></div>
            </div>

            <?php
            $attributes = [
                'id',
                [
                    'attribute' => 'type_id',
                    'value' => function ($model) {
                        $arr = ArrayHelper::map(ObjectType::find()->all(), 'id', 'title');
                        return $arr[$model->type_id];
                    }
                ],
                [
                    'attribute' => 'status',
                    'value' => function ($model) {
                        return $model->status ? 'Да' : 'Нет';
                    }
                ],
                [
                    'attribute' => 'status_object',
                    'value' => function ($model) {
                        switch ($model->status_object) {
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
                    'attribute' => 'city_id',
                    'value' => function ($model, $cityLocalityTypeId) {
                        $city = \backend\models\object_settings\CitySearch::findOne(['id' => $model->city_id]);
                        if (!isset($city)) {
                            $cityName = null;
                            if ($model->locality_type_id != $cityLocalityTypeId) {
                                $localityType = \common\models\object\LocalityType::find()->where(['id' => $model->locality_type_id])->one();
                                $cityName = $localityType->name;
                            }
                        } else {
                            $cityName = $city->name;
                        }
                        return $cityName;
                    }
                ],
                [
                    'attribute' => 'place_km',
                    'value' => function ($model) {
                        if ($model->place_km === 0) {
                            $city = \backend\models\object_settings\CitySearch::findOne(['id' => $model->city_id]);
                            return $city->name;
                        } else {
                            return Yii::$app->formatter->asInteger($model->place_km) . ' км. от МКАД';
                        }
                    }
                ],
                'amount:integer',
                'address',
                'address_map',
                [
                    'attribute' => 'area',
                    'value' => function ($model) {
                        return Yii::$app->formatter->asDecimal($model->area) . ' кв.м';
                    }
                ],
                [
                    'attribute' => 'rooms',
                    'value' => $model->rooms,
                    'visible' => !$isCommerce
                ],
                'owner',
                'price_cadastral:integer',
                'price_tian:integer',
                'price_market:integer',
                'price_liquidation:integer'
            ];
            $houseType = ObjectType::find()->where(['title' => 'Дом'])->one();
            if ($model->type_id == $houseType->id) {
                $attributes = ArrayHelper::merge($attributes, [
                    'land_price_cadastral:integer',
                    'land_price_tian:integer',
                    'land_price_market:integer',
                    'land_price_liquidation:integer',
                ]);
            }
            $attributes = ArrayHelper::merge($attributes, [
                'rate',
                'term',
                [
                    'attribute' => 'schedule_payments',
                    'value' => function ($model) {
                        return ($model->schedule_payments === 1) ? 'шаровый' : 'аннуитетный';
                    }
                ],
                'nks:integer',
                [
                    'attribute' => 'created_at',
                    'value' => function ($model) {
                        return Yii::$app->date->month($model->created_at);
                    }
                ],
                [
                    'attribute' => 'updated_at',
                    'value' => function ($model) {
                        return Yii::$app->date->month($model->updated_at);
                    }
                ],
            ]);

            foreach ($confidences as $confId => $title) {
                $attributes[] = [
                    'label' => $title,
                    'value' => $objectConfidences[$confId]->check ? 'Да' : 'Нет'
                ];
                $attributes[] = [
                    'label' => $title . '(рейтинг)',
                    'value' => $objectConfidences[$confId]->rate
                ];
                $file = '-';
                if (isset($objectConfidencesFiles[$confId])) {
                    $file = Html::a($objectConfidencesFiles[$confId]->title, $objectConfidencesFiles[$confId]->doc, ['class' => 'form-a-del', 'data-pjax' => '0', 'download' => true]) . '</p>';
                }
                $attributes[] = [
                    'label' => $title . '(файл)',
                    'value' => $file,
                    'format' => 'raw'
                ];
            }
            ?>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => $attributes,
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
            $link = str_replace('admin', '', Url::home(true) . $img->img_min);
            echo Html::img($link);
        }

        Fotorama::end();
    }
    ?>

    <?php if (!empty($files)) { ?>
        <h3>Документы</h3>
        <hr>
        <?php foreach ($files as $file) { ?>
            <div>
                <?= Html::a($file->title, $file->doc, ['class' => 'form-a-del', 'download' => true]) . '</p>'; ?>
            </div>
        <?php } ?>
    <?php } ?>

</div>
