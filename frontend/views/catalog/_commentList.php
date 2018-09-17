<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;
?>

<li class="col-12 news-comment" style="padding-left:<?= (($model->level) * 40) ?>px">
    <div class="avatar">
        <img src="/img/object/no-photo.jpg">
    </div>
    <div class="comment-action">
        <!-- <label>#<?= $model->id ?></label> | -->
        <h5><?= Html::encode($model->user_name) ?><!-- | <?= $model->datetime ?>--></h5><!--  |
        <?php if ($model->comment_id){ ?>
            <label>комм к <?= $model->comment_id ?> посту</label>
        <?php } ?> -->
        <p class="c_msg m-b-0">
            <?= HtmlPurifier::process($model->text) ?>
        </p>
        <div class="badge badge-primary"><?= $model->id ?></div>
        <small class="comment-date float-sm-right"><?= $model->datetime ?></small>
    </div>
    <div class="answer-form-<?= $model->id ?>">
        <button class="btn btn-link" onclick="openAnswer(<?= $model->id . ', ' . $model->level ?>)">Ответить</button>
    </div>
</li>