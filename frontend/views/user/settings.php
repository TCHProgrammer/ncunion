<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Notice;
use common\components\maskedinput\MaskedInput;

$this->title = 'Настройки';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="settings-block-1">
    <div class="row clearfix">
        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>общая информация:</h2>
                </div>

                <div class="body">

                    <h2 class="card-inside-title">общая информация:</h2>
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <?php if (isset($avatar->avatar)){ ?>
                                <?= Html::label('Текущая картинка') ?>
                                <div class="form-update-pic">
                                    <?= Html::img($avatar->avatar) ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-6">

                            <?= $form->field($model, 'imageFile')->fileInput()?>

                            <?= $form->field($model, 'last_name', ['options' => ['class' => 'form-height']])->textInput() ?>

                            <?= $form->field($model, 'first_name', ['options' => ['class' => 'form-height']])->textInput() ?>

                            <?= $form->field($model, 'middle_name', ['options' => ['class' => 'form-height']])->textInput() ?>

                            <?= $form->field($model, 'email', ['options' => ['class' => 'form-height']])->textInput() ?>

                            <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
                                'mask' => '+7(999)999-9999',
                            ]) ?>

                            <?= $form->field($model, 'company_name', ['options' => ['class' => 'form-height']])->textInput() ?>

                        </div>
                    </div>

                    <h2 class="card-inside-title">Уведомления по почте:</h2>

                    <div class="row clearfix">
                        <div class="col-sm-6">

                            <?= $form->field($model, 'tagsArray')->checkboxList(
                                Notice::find()->select(['title', 'id'])->indexBy('id')->column()
                            )->label(false) ?>

                        </div>
                    </div>

                    <br>

                    <div class="form-group">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                    </div>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<div class="settings-block-2">
    <div class="row">
        <?php $formPas = ActiveForm::begin([
            'action' => 'update-password'
        ]); ?>

        <div class="col-lg-12">

            <h2>Изменить пароль:</h2>

            <?= $formPas->field($updatePas, 'password', ['options' => ['class' => 'form-height']])->passwordInput() ?>

            <?= $formPas->field($updatePas, 'password_repeat', ['options' => ['class' => 'form-height']])->passwordInput() ?>

            <?= $formPas->field($updatePas, 'password_new', ['options' => ['class' => 'form-height']])->passwordInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
