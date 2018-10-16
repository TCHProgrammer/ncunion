<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model common\models\object\Object */

$this->title = 'Создание нового объекта';
$this->params['breadcrumbs'][] = ['label' => 'Каталог объектов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title . ' (этап 1 из 3)';
?>
<div class="object-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], ]); ?>

    <?= $this->render('_form', [
        'model' => $model,
        'values' => $values,
        'listCheckbox' => $listCheckbox,
        'rezCheckbox' => $rezCheckbox,
        'listRadio' => $listRadio,
        'rezRadio' => $rezRadio,
        'region' => $region,
        'cities' => $cities,
        'localityType' => $localityType,
    ]) ?>

</div>
