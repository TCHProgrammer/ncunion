<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\object\Confidence;
use common\models\object\ConfidenceObject;
use common\models\object\City;

/* @var $this  yii\web\View */
/* @var $model common\models\object\Object */


/* доверие объекту */
$allListConf = count(Confidence::find()->all());
$listConf = count(ConfidenceObject::find()->where(['object_id' => $model->id])->all());
$conf = round($listConf * 100 / $allListConf, 2);
$productImageCount = count($model->objectImgs);
?>

<div class="col-xlg-3 col-lg-4 col-md-4 col-sm-6 col-xs-12" data-key="<?= $model->id; ?>">
    <div class="card product_item">
        <div class="body">

            <div class="cp_img">
                <div class="product_tags">
                    <?php if(!is_null($model->nks)){ ?>
                        <div class="object-tag object-tag-nks"></div>
                    <?php } ?>

                    <?php foreach ($model->tag as $tag){ ?>
                        <?php if ($tag->id === 1) { ?>
                        <div class="object-tag object-tag-<?= $tag->id ?>">
                            <?= $tag->title ?>
                        </div>
                        <?php } ?>
                    <?php } ?>
                </div>
                <div class="product_trust">
                    <input type="text" class="trust_o_meter" readonly="readonly" value="<?= $conf ?>" data-width="50" data-height="50" data-thickness="0.2" data-fgColor="#FF1601" data-bgColor="#B9B9B9" disabled>
                </div>
                <?php if ($productImageCount > 1) {
                    $imageWrapperClass = " owl-carousel product_carousel";
                } else {
                    $imageWrapperClass = "";
                } ?>
                <div class="cp_img_wrapper<?php echo $imageWrapperClass; ?>">
                    <?php if ($productImageCount > 1){ ?>
                        <?php foreach ($model->objectImgs as $item){ ?>
                        <a href="<?= Url::toRoute('/catalog/view?id='.$model->id) ?>">
                            <img class="img-fluid" src="<?=  isset($item->img_min) ? $item->img_min : $item->img ?>">
                        </a>
                        <?php } ?>
                    <?php } else if ($productImageCount == 1) { ?>
                    <a href="<?= Url::toRoute('/catalog/view?id='.$model->id) ?>">
                        <img class="img-fluid" src="<?= $model->objectImgs[0]->img_min ?>">
                    </a>
                    <?php } else { ?>
                    <a href="<?= Url::toRoute('/catalog/view?id='.$model->id) ?>">
                        <img class="img-fluid" src="/img/object/no-photo.jpg">
                    </a>
                    <?php } ?>
                </div>

                <?php // TODO: Избавиться от еще одного цикла тегов. ?>
                <?php foreach ($model->tag as $tag){ ?>
                    <?php if ($tag->id === 2) { ?>
                <div class="product_action">
                    <?= $tag->title ?>
                </div>
                    <?php } ?>
                <?php } ?>
                <div class="hover">
                    <button type="button" class="btn btn-default waves-effect product_favorite" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="zmdi zmdi-favorite-outline"></i></button>
                    <a href="<?= Url::toRoute('/catalog/view?id='.$model->id) ?>" class="btn btn-default waves-effect waves-float product_link"><i class="zmdi zmdi-chevron-right"></i></a>
                </div>
            </div>

            <div class="product_details">
                <h5 title="<?= $model->title ?>"><a href="<?= Url::toRoute('/catalog/view?id='.$model->id) ?>"><?= $model->title ?></a></h5>
                <?php
                $cityArray = City::find()->where(['id' => $model->city_id])->one();
                ?>
                <?php if(!is_null($cityArray->name)) { ?>
                <div class="product_city">
                    <p><?= $cityArray->name ?></p>
                </div>
                <?php } ?>
                <div class="product_info">
                    <p>
                        <?php // TODO: Пофиксить запятые. ?>
                        <?= $model->typeTitle . ', '?>
                        <?php if(!is_null($model->rooms)) { ?>
                            <?= $model->rooms . ' комн.,' ?>
                        <?php } ?>
                        <?php if(!is_null($model->area)) { ?>
                            <?= $model->area . ' м²' ?>
                        <?php } ?>
                    </p>
                </div>
                <div class="product_price price">
                    <span class="value"><?= $model->amount ?> &#8381;</span>
                    <span class="product_help">Требуемая сумма</span>
                </div>
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
        </div>
    </div>
</div>