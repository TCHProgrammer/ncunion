<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\ListView;
?>

<div class="comments comments-fon">
    <div class="comments-field">
        <?= ListView::widget([
            'dataProvider' => $commentList,
            'itemView' => '_commentList',
            'viewParams' => [
                'commentNew' => $commentNew,
                'oId' => $oId
            ],
            'summary' => false,
        ]);
        ?>
    </div>
    <div class="comments-form">
        <?php $form = ActiveForm::begin([
            'action' => 'comment'
        ]) ?>
            <div class="comments-input-text">
                <?= $form->field($commentNew,'object_id')->hiddenInput(['value' => $oId])->label(false) ?>

                <?= $form->field($commentNew,'level')->hiddenInput(['value' => 0])->label(false) ?>

                <?= $form->field($commentNew,'text',  ['options' => ['class' => 'comments-textarea']])->textarea()->label(false) ?>
            </div>
            <div class="comments-form-btn">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
            </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
