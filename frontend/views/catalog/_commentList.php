<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;
?>

<div class="news-comment" style="padding-left:<?= (($model->level) * 40) ?>px">
    <div class="comment-head">
        <label>#<?= $model->id ?></label> |
        <label><?= Html::encode($model->user_name) ?> | <?= $model->datetime ?></label> |
        <?php if ($model->comment_id){ ?>
            <label>комм к <?= $model->comment_id ?> посту</label>
        <?php } ?>
    </div>
    <div class="comment-body">
        <?= HtmlPurifier::process($model->text) ?>
    </div>

    <div class="answer-form-<?= $model->id ?>">
        <button class="btn btn-link" onclick="openAnswer(<?= $model->id . ', ' . $model->level ?>)">Ответить</button>
    </div>

    <hr>
</div>