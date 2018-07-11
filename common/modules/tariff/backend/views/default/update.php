<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\tariff\models\Tariff */

$this->title = Yii::t('app', 'Update Tariff: {nameAttribute}', [
    'nameAttribute' => $model->title
]);
$this->params['breadcrumbs'][] = ['label' => 'Tariffs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tariff-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
