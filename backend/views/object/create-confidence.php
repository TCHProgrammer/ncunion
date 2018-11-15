<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\object\Object */

$this->title = 'Добавление справок к объекту';
$this->params['breadcrumbs'][] = ['label' => 'Каталог объектов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title . ' (этап 4 из 4)';
?>
<div class="object-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],]); ?>

    <?php Pjax::begin(); ?>
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data', 'data-pjax' => true],
    ]) ?>
    <?= $this->render('_formConfidence', [
        'objectConfidences' => $objectConfidences,
        'model' => $model,
        'confidences' => $confidences,
        'confidenceAddFiles' => $confidenceAddFiles,
        'confidenceFilesList' => $confidenceFilesList,
    ]) ?>

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']); ?>
    <?php ActiveForm::end() ?>
    <?php Pjax::end(); ?>
    <?= Html::a('Завершить', Url::toRoute('view?id=' . $model->id), ['class' => 'btn btn-primary']) ?>

</div>
