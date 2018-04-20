<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\object\Prescribed */

$this->title = 'Create Prescribed';
$this->params['breadcrumbs'][] = ['label' => 'Prescribeds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prescribed-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
