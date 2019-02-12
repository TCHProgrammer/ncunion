<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\MyObjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Подтверждение телефона';
?>
<div class="object-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <div class="row">
        <div class="col-lg-4">
            <?php $form = ActiveForm::begin() ?>

            <?= $form->field($model, 'code') ?>

            <div id="time-phone" style="display: none">
                Для повторной отправки осталось <span id="time-phone-cmc"></span> секунд
            </div>

            <div class="form-group">
                <?= Html::submitButton('Продолжить', ['class' => 'btn btn-primary']) ?>
                <?= Html::button('Отправить смс', ['class' => 'btn btn-primary', 'id' => 'push-phone-cmc']) ?>
            </div>

            <span id="res-phone-cmc"></span>
        </div>

        <?php ActiveForm::end() ?>
    </div>



</div>
