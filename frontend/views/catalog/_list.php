<?php
use yii\helpers\Url;
use common\models\object\Confidence;
use common\models\object\ConfidenceObject;

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
                <h5><a href="<?= Url::toRoute('/catalog/view?id='.$model->id) ?>"><?= $model->title ?></a></h5>
                <ul class="product_price list-unstyled">
                    <li class="price"><?= $model->amount ?> руб.</li>
                </ul>
                <div class="object-conf" style="top:10px;">
                    Доверие <?= $conf ?>%
                </div>
                <?php if(!is_null($model->nks)){ ?>
                    <div class="object-ncs" style="top:10px;">
                        НКС: <?= $model->nks ?>
                    </div>
                <?php } ?>
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