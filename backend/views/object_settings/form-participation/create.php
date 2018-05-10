<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model common\models\passport\FormParticipation */

$this->title = 'Добавить новую форму участия';
$this->params['breadcrumbs'][] = [
    'label' => 'Каталог объектов',
    'url' => ['/object']
];
$this->params['breadcrumbs'][] = ['label' => 'Форма участия', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-participation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], ]); ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
