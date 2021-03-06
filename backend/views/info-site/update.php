<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\InfoSite */

$this->title = 'Update Info Site: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Info Sites', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="info-site-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
