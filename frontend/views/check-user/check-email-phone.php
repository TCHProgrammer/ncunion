<?php
use yii\helpers\Html;
use common\models\UserModel;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$user = UserModel::findOne(Yii::$app->user->id);

if($user){
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
}

?>

<h3><?= Html::encode($this->title) ?></h3>

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

        <div class="form-group">
            <?= Html::a('Подтвердить телефон', Url::toRoute('phone'), ['class' => 'btn btn-primary']) ?>
        </div>

    <?php } ?>

</div>


