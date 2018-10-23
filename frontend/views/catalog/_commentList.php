<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;

/* @var $model common\models\object\Object */
?>

<li class="col-12 news-comment news-comment-level-<?= $model->level ?>" style="padding-left:<?= (($model->level) * 20) ?>px">
    <div class="comment-padding comment-padding-level-<?= $model->level ?>" style="width:<?= (($model->level) * 20) ?>px"></div>
    <div class="avatar">
        <img class="rounded" src="/img/object/no-photo.jpg" alt="user" width="60">
    </div>
    <div class="comment-action">
        <!-- <label>#<?= $model->id ?></label> | -->
        <h5 class="c_name"><?= Html::encode($model->user_name) ?><!-- | <?= $model->datetime ?>--></h5><!--  |
        <?php if ($model->comment_id){ ?>
            <label>комм к <?= $model->comment_id ?> посту</label>
        <?php } ?> -->
        <p class="c_msg m-b-0">
            <?= HtmlPurifier::process($model->text) ?>
        </p>
        <div class="badge badge-primary"><?= $model->id ?></div>
        <small class="comment-date float-sm-right"><?= $model->datetime ?></small>
    </div>
    <div class="answer-form-comment answer-form-<?= $model->id ?>">
        <button class="btn btn-raised btn-success waves-effect" onclick="openAnswer(<?= $model->id . ', ' . $model->level ?>)">Ответить</button>
    </div>
</li>