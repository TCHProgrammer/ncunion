<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model common\models\object\City */

$this->title = 'Изменить название города: ' . $model->name;
$this->params['breadcrumbs'][] = [
    'label' => 'Каталог объектов',
    'url' => ['/object']
];
$this->params['breadcrumbs'][] = ['label' => 'Список городов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Изменить ' . $model->name];
?>
<div class="tag-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], ]); ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
