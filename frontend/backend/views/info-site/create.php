<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\InfoSite */

$this->title = 'Create Info Site';
$this->params['breadcrumbs'][] = ['label' => 'Info Sites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="info-site-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
