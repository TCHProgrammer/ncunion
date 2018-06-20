<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\object\ObjectType;
use common\models\passport\FormParticipation;

$this->title="Паспорт клиента";
?>

<h1><?= Html::encode($this->title) ?></h1>


<div class="object-form">
    <div class="row">

        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-lg-12">
                <?= $form->field($model, 'type_id', ['options' => ['class' => 'form-height']])->dropDownList(
                    ArrayHelper::map(ObjectType::find()->all(), 'id', 'title'),
                    ['prompt' => 'Выберите тип объекта...']
                ) ?>
            </div>
        </div>

        <div class="row">
            <!-- цена -->
            <div class="col-lg-4">
                <?= $form->field($model, 'amount_min', ['options' => ['class' => 'input-adjustment col-lg-6 col-md-6']]) ?>

                <?= $form->field($model, 'amount_max', ['options' => ['class' => 'input-adjustment col-lg-6 col-md-6']]) ?>

                <div class="col-lg-12">
                    <input id="price-slider"
                        data-slider-id='ex1Slider'
                        type="text"
                        data-slider-min="<?= $model->amount_min ?>"
                        data-slider-max="<?= $model->amount_max ?>"
                        data-slider-step="1"
                        data-slider-value="[<?= $model->amount_min ?>, <?= $model->amount_max ?>]"
                    />
                </div>
            </div>

            <!-- площадь -->
            <div class="col-lg-4">
                <?= $form->field($model, 'area_min', ['options' => ['class' => 'input-adjustment col-lg-6 col-md-6']]) ?>

                <?= $form->field($model, 'area_max', ['options' => ['class' => 'input-adjustment col-lg-6 col-md-6']]) ?>

                <div class="col-lg-12">
                    <input id="area-slider"
                        data-slider-id='ex1Slider'
                        type="text"
                        data-slider-min="<?= $model->area_min ?>"
                        data-slider-max="<?= $model->area_max ?>"
                        data-slider-step="1"
                        data-slider-value="[<?= $model->area_min ?>, <?= $model->area_max ?>]"
                    />
                </div>
            </div>

            <!-- комнаты -->
            <div class="col-lg-4">
                <?= $form->field($model, 'rooms_min', ['options' => ['class' => 'input-adjustment col-lg-6 col-md-6']]) ?>

                <?= $form->field($model, 'rooms_max', ['options' => ['class' => 'input-adjustment col-lg-6 col-md-6']]) ?>

                <div class="col-lg-12">
                    <input id="rooms-slider"
                        data-slider-id='ex1Slider'
                        type="text"
                        data-slider-min="<?= $model->rooms_min ?>"
                        data-slider-max="<?= $model->rooms_max ?>"
                        data-slider-step="1"
                        data-slider-value="[<?= $model->rooms_min ?>, <?= $model->rooms_max ?>]"
                    />
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <?= $form->field($model, 'form_participation_id')->radioList(ArrayHelper::map(FormParticipation::find()->all(), 'id', 'title')) ?>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
