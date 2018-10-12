<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\ListView;
?>

<div class="comments comments-fon">
    <div class="comments-field col-sm-12">
        <?= ListView::widget([
            'dataProvider' => $commentList,
            'itemView' => '_commentList',
            'options' => [
                'tag' => 'ul',
                'class' => 'row list-unstyled c_review'
            ],
            'itemOptions' => [
                'tag' => false
            ],
            'viewParams' => [
                'commentNew' => $commentNew,
                'oId' => $oId
            ],
        ]); ?>
    </div>

    <!-- форма ответа для комментирования -->
    <div class="form-push" style="display: none">
        <?php $form = ActiveForm::begin([
            'action' => 'comment'
        ]) ?>
        <div class="comments-input-text">
            <?= $form->field($commentNew,'object_id',  ['options' => ['id' => 'answer-firm-object_id']])->textInput(['class' => 'answer-firm-object_id'])->hiddenInput(['value' => $oId])->label(false) ?>

            <?= $form->field($commentNew,'comment_id',  ['options' => ['id' => 'answer-firm-comment_id']])->textInput(['class' => 'answer-firm-comment_id'])->hiddenInput(['value' => null])->label(false) ?>

            <?= $form->field($commentNew,'level',  ['options' => ['id' => 'answer-firm-level']])->textInput(['class' => 'answer-firm-level'])->hiddenInput(['value' => 0])->label(false) ?>

            <div class="form-group form-group-comment">
                <?= $form->field($commentNew,'text',  ['options' => ['id' => 'answer-firm-text', 'class' => 'form-line']])->textInput(['class' => 'answer-firm-text'])->textarea()->label(false) ?>
            </div>
        </div>
        <div class="comments-form-btn">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end() ?>
    </div>

    <!-- форма простого комментирования -->
    <div class="comments-form">
        <?php $form = ActiveForm::begin([
            'action' => 'comment'
        ]) ?>
            <div class="comments-input-text">
                <?= $form->field($commentNew,'object_id')->hiddenInput(['value' => $oId])->label(false) ?>

                <?= $form->field($commentNew,'level')->hiddenInput(['value' => 0])->label(false) ?>
                <div class="form-group form-group-comment" id="comment-input-send">
                        <?= $form->field($commentNew,'text',  ['options' => ['class' => 'comments-textarea form-line']])->textarea()->label(false) ?>
                </div>
            </div>
            <div class="comments-form-btn">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
            </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
