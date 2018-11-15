<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\Pjax;

/* @var $this  yii\web\View */
/* @var $model common\models\object\Object */
/* @var $time  int */

$this->title = 'Изменить объект: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Каталог объектов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="object-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],]); ?>

    <div class="object-form">
        <?= $this->render('_formFiles', [
            'addFile' => $addFile,
            'listFiles' => $listFiles,
        ]) ?>
        <!-- $time чекнуть -->

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
            'brokersCollection' => $brokersCollection,
            'addFile' => $addFile,
            'objectConfidences' => $objectConfidences,
            'confidences' => $confidences,
            'confidenceAddFiles' => $confidenceAddFiles,
            'confidenceFilesList' => $confidenceFilesList
        ]) ?>
    </div>

</div>
