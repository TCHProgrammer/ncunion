<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\object\ObjectType;

/* @var $this yii\web\View */
/* @var $model frontend\models\ObjectSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="object-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <?= $form->field($model, 'title', ['options' => ['class' => 'input-adjustment col-lg-4 col-md-4']]) ?>

        <?= $form->field($model, 'type_id', ['options' => ['class' => 'input-adjustment col-lg-2 col-md-2']])->dropDownList(
            ArrayHelper::map(ObjectType::find()->all(), 'id', 'title'),
            ['prompt' => 'Выберите тип объекта...']
        ) ?>

        <?= $form->field($model, 'place_km', ['options' => ['class' => 'input-adjustment col-lg-2 col-md-2']])->dropDownList(
            [
                0 => 'Москва',
                10 => 'до 10 км от МКАД',
                25 => 'до 25 км от МКАД',
                50 => 'до 50 км от МКАД',
                100 => 'до 100 км от МКАД',
            ],
            ['prompt' => 'Выберите удалённость от Москвы...']
        ) ?>

        <?= $form->field($model, 'amount_min', ['options' => ['class' => 'input-adjustment col-lg-2 col-md-2']]) ?>

        <?= $form->field($model, 'amount_max', ['options' => ['class' => 'input-adjustment col-lg-2 col-md-2']]) ?>

    </div>

    <div class="row">
        <?= $form->field($model, 'area', ['options' => ['class' => 'input-adjustment col-lg-2 col-md-2']]) ?>

        <?= $form->field($model, 'rooms', ['options' => ['class' => 'input-adjustment col-lg-2 col-md-2']]) ?>

        <?= $form->field($model, 'price_cadastral', ['options' => ['class' => 'input-adjustment col-lg-2 col-md-2']]) ?>

        <?= $form->field($model, 'price_tian', ['options' => ['class' => 'input-adjustment col-lg-2 col-md-2']]) ?>

        <?= $form->field($model, 'price_market', ['options' => ['class' => 'input-adjustment col-lg-2 col-md-2']]) ?>

        <?= $form->field($model, 'price_liquidation', ['options' => ['class' => 'input-adjustment col-lg-2 col-md-2']]) ?>
    </div>

    <?php //var_dump($_GET); ?>

    <?php foreach ($listCheckboxes as $itemCheckbox){ ?>
        <div class="form-attribute form-attribute-<?= $itemCheckbox->type_id ?>"  style="<?= ($itemCheckbox->type_id == $model->type_id)?'display: block':'display: none' ?>">
            <label><?= $itemCheckbox->title ?></label>
            <div>
                <?php foreach ($itemCheckbox->groupCheckboxes as $itemGroup){ ?>
                    <label class="checkbox">
                        <input type="checkbox" name="GroupCheckboxes[<?= $itemCheckbox->type_id ?>][<?= $itemCheckbox->id ?>][]" value="<?= $itemGroup->id ?>" <?= (in_array($itemGroup->id, $rezCheckboxes))?'checked':'' ?>>
                        <?= $itemGroup->title ?>
                    </label>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

    <div class="row">
        <?php foreach ($listRadios as $itemRadio){ ?>
            <div class="form-attribute form-attribute-<?= $itemRadio->type_id ?>"  style="<?= ($itemRadio->type_id == $model->type_id)?'display: block':'display: none' ?>">
                <label><?= $itemRadio->title ?></label>
                <?php foreach ($itemRadio->groupRadios as $itemGroup){ ?>
                    <label class="radio">
                        <input type="radio" name="GroupRadios[<?= $itemRadio->type_id ?>][<?= $itemRadio->id ?>][]" value="<?= $itemGroup->id ?>" <?= (in_array($itemGroup->id, $rezRadios))?'checked':'' ?>>
                        <?= $itemGroup->title ?>
                    </label>
                <?php } ?>
            </div>
        <?php } ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Сбросить фильтр', ['/catalog'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
