<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\MyObjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Мои объекты';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="content catalog-page object-index">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
        </div>
    </div>
    <div class="container-fluid">
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
            ],
            'emptyTextOptions' => [
                'class' => 'col-sm-12'
            ],
            'emptyText' => '<div class="card"><div class="body"><div class="empty">Ничего не найдено</div></div></div>'
            // TODO: Вот этот ужас надо бы потом исправить.
        ]); ?>
    </div>
</section>
