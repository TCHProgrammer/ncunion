<?php
use yii\helpers\Url;
use common\models\object\Confidence;
use common\models\object\ConfidenceObject;

/* @var $this  yii\web\View */
/* @var $model common\models\object\Object */


/* доверие объекту */
$allListConf = count(Confidence::find()->all());
$listConf = count(ConfidenceObject::find()->where(['object_id' => $model->id])->all());
$conf = round($listConf * 100 / $allListConf, 2);
?>

<div class="col-lg-3 col-md-4 col-sm-12" data-key="<?= $model->id; ?>">
    <div class="card product_item">
        <div class="body">

            <div class="cp_img">
                <?php if (isset($model->objectImgs[0]->img)){ ?>
                    <img class="img-fluid" src="<?= $model->objectImgs[0]->img ?>">
                <?php }else{ ?>
                    <img class="img-fluid" src="/img/object/no-photo.jpg">
                <?php } ?>
                <div class="hover">
                    <a href="<?= Url::toRoute('/catalog/view?id='.$model->id) ?>" class="btn btn-default waves-effect waves-float"><i class="zmdi zmdi-plus"></i></a>
                </div>
            </div>

            <div class="product_details">
                <h5 title="<?= $model->title ?>"><a href="<?= Url::toRoute('/catalog/view?id='.$model->id) ?>"><?= $model->title ?></a></h5>
                <?php if(!is_null($model->address)) { ?>
                <span class="product_city"><?= $model->address ?></span>
                <?php } ?>
                <span class="product_info">
                    <?php // TODO: Пофиксить запятые. ?>
                    <?= $model->typeTitle . ', '?>
                    <?php if(!is_null($model->rooms)) { ?>
                    <?= $model->rooms . ' комн.,' ?>
                    <?php } ?>
                    <?php if(!is_null($model->area)) { ?>
                    <?= $model->area . ' м²' ?>
                    <?php } ?>
                </span>
                <div class="product_price price">
                    <span class="value"><?= $model->amount ?> &#8381;</span>
                    <span class="product_help">Требуемая сумма</span>
                </div>
                <div class="product_bottom">
                    <?php if(!is_null($model->price_tian)) { ?>
                    <div class="product_cian">
                        <span class="product_help">ЦИАН</span>
                        <span class="value"><?= $model->price_tian ?> &#8381;</span>
                    </div>
                    <?php } ?>
                    <?php if(!is_null($model->price_market)) { ?>
                    <div class="product_market_price">
                        <span class="product_help">Рыночная стоимость</span>
                        <span class="value"><?= $model->price_market ?> &#8381;</span>
                    </div>
                    <?php } ?>
                </div>
                <?php $styleTag = 10 ;?>
                <?php foreach ($model->tag as $tag){ ?>
                    <div class="object-tag" style="top: <?= $styleTag ?>px;">
                        <?= $tag->title ?>
                    </div>
                    <?php $styleTag += 50; ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>