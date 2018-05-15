<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\object\AttributeRadio */

$this->title = 'Изменить атрибут: ' . $model->title;
$this->params['breadcrumbs'][] = [
    'label' => 'Каталог объектов',
    'url' => ['/object']
];
$this->params['breadcrumbs'][] = ['label' => 'Дополнительные атрибуты: переключатель', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Изменить';
?>

<div class="attribute-radio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], ]); ?>

    <h3>Атрибут</h3>

    <div class="attribute-checkbox-form-update">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <h3>Элементы атрибута</h3>

        <div class="row form-group">
            <?php foreach($groupList as $item){ ?>
                <div class="form-group-input col-lg-3">
                    <input type="text" class="form-control input-group" name="Group[<?= $item->id ?>][title]" value="<?= $item->title ?>">
                    <?= Html::a('', Url::to(['delete-item', 'id' => $item->id, 'attribute' => $model->id]), ['class' => 'glyphicon glyphicon-trash btn-del-group']) ?>
                </div>
            <?php } ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            <?= Html::button('Добавить новый элемент', ['class' => 'btn btn-primary', 'data-toggle' => 'modal', 'data-target' => '.bs-example-modal-lg']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <!-- modal -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <?php $formCheckbox = ActiveForm::begin(); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Добавить новый элемент</h4>
                </div>
                <div class="modal-body modal-checkbox">
                    <?= $formCheckbox->field($addGroup, 'title')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</div>