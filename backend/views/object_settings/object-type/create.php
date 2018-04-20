<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\object\ObjectType */

$this->title = 'Create Object Type';
$this->params['breadcrumbs'][] = ['label' => 'Object Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="object-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
