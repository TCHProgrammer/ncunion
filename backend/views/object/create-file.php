<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\object\Object */

$this->title = 'Добавление документов к объекту';
$this->params['breadcrumbs'][] = ['label' => 'Каталог объектов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title . ' (этап 3 из 4)';
?>
<div class="object-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], ]); ?>

    <?= $this->render('_formFiles', [
        'addFile' => $addFile,
        'listFiles' => $listFiles,
    ]) ?>

    <?= Html::a('Далее', Url::toRoute('create-confidence?id=' . $objectId), ['class' => 'btn btn-primary']) ?>

</div>
