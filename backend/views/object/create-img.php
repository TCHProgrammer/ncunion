<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\object\Object */

$this->title = 'Добавление изображений к объекту';
$this->params['breadcrumbs'][] = ['label' => 'Каталог объектов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title . ' (этап 2 из 3)';
?>
<div class="object-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], ]); ?>

    <div class="create-object-img">
        <?= $this->render('_formImgs', [
            'model' => $model
        ]); ?>
    </div>

    <?= Html::a('Далее', Url::toRoute('create-file?id=' . $model->id), ['class' => 'btn btn-primary']) ?>

</div>
