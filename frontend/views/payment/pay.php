<?php
use yii\helpers\Html;
$this->title = "Покупка тарифа";
?>

<h1><?= Html::encode($this->title); ?></h1>

<div class="row">
<?php foreach ($tariffs as $tariff){
    if (!isset($tariff->discount->type)){
        $price = (int)$tariff->price;
    }else{
        switch ($tariff->discount->type){
            case 1:
                $price = $tariff->price * (1 - ($tariff->discount->number / 100));
                break;
            case 2:
                $price = $tariff->price - $tariff->discount->number;
                break;
            default:
                $price = (int)$tariff->price;
                break;
        }
    }

    pay($price, $tariff)

    ?>
<?php } ?>
</div>

<!-- number_format($price, 2, '.', '') -->

<?php function pay($price, $tariff){ ?>
    <div class="pay-fon">
        <div class="pay-tariff col-lg-4">
            <h3><?= $tariff->title ?></h3>
            <p><?= $tariff->days ?> дней</p>
        </div>
        <?php if ($price == $tariff->price){ ?>
            <div class="pay-price text-center col-lg-4">
                <label><?= number_format($price, 2, '.', '') ?></label>
                <p>руб.</p>
            </div>
        <?php }else{ ?>
            <div class="pay-price price-discont text-center col-lg-4">
                <div class="pay-discont-line1"></div>
                <div class="pay-discont-line2"></div>
                <div class="pay-new-price"><?= $price ?> руб.</div>
                <label><?= $tariff->price ?></label>
                <p>руб.</p>
            </div>
        <?php } ?>
        <div class="pay-btn-pole text-center col-lg-4">
            <button class="pay-btn">Купить</button>
        </div>
    </div>
    <br>
<?php } ?>
