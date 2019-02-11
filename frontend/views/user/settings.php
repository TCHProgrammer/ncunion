<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Notice;
use common\components\maskedinput\MaskedInput;

$this->title = 'Настройки';
?>

<section class="content profile-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
        </div>
    </div>
    <div class="container-fluid">

        <div class="settings-block-1 col-md-8">
            <div class="row clearfix">
                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <div class="card">

                    <div class="body">
                        <h2 class="card-inside-title">общая информация:</h2>
                        <div class="row clearfix">
                            <div class="col-md-4 form-update-pic">
                                <?php if (isset($avatar->avatar)){ ?>
                                    <?= Html::label('Текущая картинка') ?>
                                    <?= Html::img($avatar->avatar) ?>
                                <?php } ?>
                                <div class="form-group">
                                    <?= $form->field($model, 'imageFile', ['options' => ['class' => 'form-line']])->fileInput()?>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-4">
                              <div class="form-group">
                                <?= $form->field($model, 'last_name', ['options' => ['class' => 'form-line']])->textInput() ?>
                              </div>
                            </div>

                            <div class="col-sm-6 col-md-4">
                              <div class="form-group">
                                <?= $form->field($model, 'first_name', ['options' => ['class' => 'form-line']])->textInput() ?>
                              </div>
                            </div>

                            <div class="col-sm-6 col-md-4">
                              <div class="form-group">
                                <?= $form->field($model, 'middle_name', ['options' => ['class' => 'form-line']])->textInput() ?>
                              </div>
                            </div>

                            <div class="col-sm-6 col-md-4">
                              <div class="form-group">
                                <?= $form->field($model, 'email', ['options' => ['class' => 'form-line']])->textInput() ?>
                              </div>
                            </div>

                            <div class="col-sm-6 col-md-4">
                              <div class="form-group">
                                <?= $form->field($model, 'phone', ['options' => ['class' => 'form-line']])->widget(MaskedInput::className(), [
                                    'mask' => '+7(999)999-9999',
                                ]) ?>
                              </div>
                            </div>

                            <div class="col-sm-6 col-md-4">
                              <div class="form-group">
                                <?= $form->field($model, 'company_name', ['options' => ['class' => 'form-line']])->textInput() ?>
                              </div>
                            </div>
                        </div>

                        <h2 class="card-inside-title">Уведомления по почте:</h2>

                        <div class="row clearfix">
                            <div class="col-sm-12">

                                <?= $form->field($model, 'tagsArray')->checkboxList(
                                    Notice::find()->select(['title', 'id'])->indexBy('id')->column(),
                                    [
                                        'item' => function($index, $label, $name, $checked, $value) {
                                            $checkedLabel = $checked ? 'checked' : '';
                                            $inputId = str_replace(['[', ']'], ['', ''], $name) . '_' . $index;

                                            return "<input type='checkbox' name=$name value=$value id=$inputId $checkedLabel>"
                                                . "<label class='checkbox' for=$inputId>$label</label>";
                                        }
                                    ]
                                )->label(false) ?>

                            </div>
                        </div>

                        <div class="form-group">
                            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                        </div>
                    </div>

                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

        <div class="settings-block-2 col-md-4">
            <div class="row clearfix">
                <?php $formPas = ActiveForm::begin([
                    'action' => 'update-password'
                ]); ?>

                <div class="card">

                    <div class="body">
                        <h2 class="card-inside-title">Изменить пароль:</h2>
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <?= $formPas->field($updatePas, 'password', ['options' => ['class' => 'form-line']])->passwordInput() ?>
                                </div>

                                <div class="form-group">
                                    <?= $formPas->field($updatePas, 'password_repeat', ['options' => ['class' => 'form-line']])->passwordInput() ?>
                                </div>

                                <div class="form-group">
                                    <?= $formPas->field($updatePas, 'password_new', ['options' => ['class' => 'form-line']])->passwordInput() ?>
                                </div>

                                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                            </div>
                        </div>
                    </div>

                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>
