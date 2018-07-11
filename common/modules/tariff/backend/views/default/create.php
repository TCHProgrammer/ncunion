<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\tariff\models\Tariff */

$this->title = Yii::t('app', 'Create Tariff');
$this->params['breadcrumbs'][] = ['label' => 'Tariffs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tariff-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
