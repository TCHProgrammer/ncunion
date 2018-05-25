<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;
?>

<div class="news-comment" style="padding-left:<?= (($model->level) * 40) ?>px">
    <div class="comment-head">
        <label><?= Html::encode($model->user_name) ?> | <?= $model->datetime ?></label>
    </div>
    <div class="comment-body">
        <?= HtmlPurifier::process($model->text) ?>
    </div>

    <div class="answer-form-<?= $model->id ?>">
        <button class="btn btn-link" onclick="openAnswer(<?= $model->id . ', ' . $model->level ?>)">Ответить</button>
    </div>

    <hr>
</div>

<div class="form-push" style="display: none">

    <?php $form = ActiveForm::begin([
        'action' => 'comment'
    ]) ?>
    <div class="comments-input-text">
        <?= $form->field($commentNew,'object_id',  ['options' => ['class' => 'answer-firm-object_id']])->textInput(['class' => 'answer-firm-object_id'])->hiddenInput(['value' => $oId])->label(false) ?>

        <?= $form->field($commentNew,'comment_id',  ['options' => ['class' => 'answer-firm-comment_id']])->textInput(['class' => 'answer-firm-comment_id'])->hiddenInput(['value' => null])->label(false) ?>

        <?= $form->field($commentNew,'level',  ['options' => ['class' => 'answer-firm-level']])->textInput(['class' => 'answer-firm-level'])->hiddenInput(['value' => 0])->label(false) ?>

        <?= $form->field($commentNew,'text',  ['options' => ['class' => 'answer-firm-text']])->textInput(['class' => 'answer-firm-text'])->textarea()->label(false) ?>
    </div>
    <div class="comments-form-btn">
        <?= Html::submitButton('1Отправить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end() ?>

</div>

<div class="form-pushasdasdasd" style="display: none">
    <form action="comment" method="post">
        <input type="hidden" id="commentobject-level" class="form-control" name="CommentObject[level]" value="====0000000000===">
        <input form="text">
        <div>
            <textarea id="commentobject-text" class="form-control" name="CommentObject[text]" aria-required="true"></textarea>
            <button style="float: left">Сохранить</button>
            <button onclick="closeAnswer(' + id +')">2тмена</button>
        </div>
    </form>

</div>