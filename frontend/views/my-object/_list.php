<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
?>

<div class="col-lg-3 col-md-4 col-xs-12" data-key="<?= $model->id; ?>">
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
            </div>
        </div>
    </div>
</div>