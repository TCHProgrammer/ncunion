<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Notice */

$this->title = 'Изменить уведомление: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Notices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="notice-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
