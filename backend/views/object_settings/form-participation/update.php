<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model common\models\passport\FormParticipation */

$this->title = 'Update Form Participation: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Изменить', 'url' => ['index']];
$this->params['breadcrumbs'][] = [
    'label' => 'Каталог объектов',
    'url' => ['/object']
];
$this->params['breadcrumbs'][] = ['label' => 'Форма участия', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="form-participation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], ]); ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
