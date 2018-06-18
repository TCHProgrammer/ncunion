<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ObjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Каталог';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="object-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- фильтр -->
    <?= $this->render('_search', [
        'model'         => $searchModel,
        'listValues'    => $listValues,
        'listCheckboxes' => $listCheckboxes,
        'listRadios'    => $listRadios,
        'rezCheckboxes'  => $rezCheckboxes,
        'rezRadios'     => $rezRadios
    ]); ?>

    <!-- каталог объектов -->
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_list',
    ]); ?>
</div>
