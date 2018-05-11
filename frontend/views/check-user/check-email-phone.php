<?php
use yii\helpers\Html;
use common\models\UserModel;
use yii\widgets\ActiveForm;

$user = UserModel::findOne(Yii::$app->user->id);

$check = $user->check_email.$user->check_phone;
switch ($check) {
    case '01':
        $this->title = 'Подтвердите email';
        break;
    case '10':
        $this->title = 'Подтвердите телефон';
        break;
    default:
        $this->title = 'Подтвердите email и телефон';
        break;
}
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>Для дальнейшей работы, вам необходимо подтвердить свою электронную почту и мобильный телефон</p>

<div class="check-email-and-phone">

    <?php if (!$user->check_email){ ?>
        <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'tokenEmail')->hiddenInput(['value' => 1])->label(false) ?>

            <div class="form-group">
                <?= Html::submitButton('Подтвердить ящик электронной почты', ['class' => 'btn btn-primary']) ?>
            </div>

        <?php ActiveForm::end() ?>
    <?php } ?>

    <?php if (!$user->check_phone){ ?>
        <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'tokenPhone')->hiddenInput(['value' => 1])->label(false) ?>

            <div class="form-group">
                <?= Html::submitButton('Подтвердить телефон', ['class' => 'btn btn-primary']) ?>
            </div>

        <?php ActiveForm::end() ?>
    <?php } ?>

</div>


