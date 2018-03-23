<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\rbac\models\AuthItem;

/* @var $this yii\web\View */
/* @var $model backend\modules\rbac\models\AuthAssignment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-assignment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'item_name')->dropDownList(AuthItem::getListRoles()) ?>

    <?//= $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<!--
public static function getToList() {
        return ArrayHelper::map(self::find()->all(), 'title', 'title');
    }
-->