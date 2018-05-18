<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\object\Object */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Objects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="object-view col-lg-6 col-md-6">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'type_id',
                'title',
                'descr:ntext',
                'place_km',
                'amount',
                'address',
                'address_map',
                'area',
                'rooms',
                'owner',
                'price_cadastral',
                'price_tian',
                'price_market',
                'price_liquidation',
                'status_object',
                'sticker_id',
            ],
        ]) ?>

    </div>

    <div class="col-lg-6 col-md-6">
        <div class="comments-fon">
            <div class="comments-field">

            </div>
            <div class="input">

            </div>
        </div>
    </div>
</div>

