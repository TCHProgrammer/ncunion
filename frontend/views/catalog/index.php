<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ObjectSearch */
/* @var $listValues frontend\controllers\CatalogController */
/* @var $listCheckboxes frontend\controllers\CatalogController */
/* @var $listRadios frontend\controllers\CatalogController */
/* @var $rezCheckboxes frontend\controllers\CatalogController */
/* @var $rezRadios frontend\controllers\CatalogController */
/* @var $filter array frontend\controllers\CatalogController */
/* @var $filterPassport frontend\controllers\CatalogController */
/* @var $arrFilterPassport frontend\controllers\CatalogController */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Каталог';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="object-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- фильтр -->
    <?= $this->render('_search', [
        'model'             => $searchModel,
        'listValues'        => $listValues,
        'listCheckboxes'    => $listCheckboxes,
        'listRadios'        => $listRadios,
        'rezCheckboxes'     => $rezCheckboxes,
        'rezRadios'         => $rezRadios,
        'filter'            => $filter,
        'filterPassport'    => $filterPassport,
        'arrFilterPassport' => $arrFilterPassport
    ]); ?>

    <!-- каталог объектов -->
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_list',
    ]); ?>
</div>
