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
<section class="content catalog-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
        </div>
    </div>
    <div class="container-fluid">
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
            'itemOptions' => [
                'tag' => false,
            ],
            'layout' => '{summary}{items}<div class="col-sm-12"><div class="card"><div class="body">{pager}</div></div></div>',
            'options' => [
                'class' => 'list-view row clearfix'
            ],
            'summary' => '<div class="col-sm-12"><div class="card summary"><div class="body">Показаны записи <b>{begin}-{end}</b> из <b>{totalCount}</b>.</div></div></div>',
            'pager' => [
                'linkContainerOptions' => [
                    'class' => 'page-item'
                ],
                'linkOptions' => [
                    'class' => 'page-link'
                ],
                'options' => [
                    'class' => 'pagination'
                ]
            ]
        ]); ?>
    </div>
</section>
