<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Sticker */

$this->title = 'Update Sticker: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Stickers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sticker-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
