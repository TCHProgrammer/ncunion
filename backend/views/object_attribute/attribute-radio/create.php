<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use  common\models\object\ObjectType;

/* @var $this yii\web\View */
/* @var $model common\models\object\AttributeRadio */

$this->title = 'Добавить атрибут';
$this->params['breadcrumbs'][] = [
    'label' => 'Каталог объектов',
    'url' => ['/object']
];
$this->params['breadcrumbs'][] = ['label' => 'Дополнительные атрибуты: переключатель', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="attribute-radio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], ]); ?>

    <div class="attribute-checkbox-form-create">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'type_id')->dropDownList(ArrayHelper::map(ObjectType::find()->all(), 'id', 'title'), ['prompt' => 'Выберите тип объекта...']) ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
