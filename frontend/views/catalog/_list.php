<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
?>

<div class="row object-item">
    <div class="object-item-img col-lg-6 ">
        <?php $styleTag = 10 ;?>
        <?php foreach ($model->tag as $tag){ ?>
            <div class="object-tag" style="top: <?= $styleTag ?>px;">
                <?= $tag->title ?>
            </div>
            <?php $styleTag += 50; ?>
        <?php } ?>
        <a href="<?= Url::toRoute('/catalog/view?id='.$model->id) ?>">
            <?php if (isset($model->objectImgs[0]->img)){ ?>
                <img src="<?= $model->objectImgs[0]->img ?>">
            <?php }else{ ?>
                <img src="/img/object/no-photo.jpg">
            <?php } ?>
        </a>
    </div>
    <div class="object-info col-lg-6">
        <div class="object-info-title">
            <h2>
                <a href="<?= Url::toRoute('/catalog/view?id='.$model->id) ?>"><?= $model->title ?></a>
            </h2>
        </div>
        <div class="object-info-amount">
            <label>
                <?= $model->amount ?> руб.
            </label>
        </div>
    </div>
</div>