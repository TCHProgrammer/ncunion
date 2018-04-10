<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\InfoSite;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\InfoSiteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Общая информация';
$this->params['breadcrumbs'][] = $this->title;

$object = new InfoSite();
$nameField = $object->attributeLabels('title');

?>
<div class="info-site-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="info-site-contend">
        <?php foreach ($infoSite as $title => $info){ ?>
            <?php if ($title == 'id'){continue;} ?>
            <?php if ($info){ ?>
                <p><?= $nameField[$title] ?>: <?= $info ?></p>
            <?php } ?>
        <?php } ?>
    </div>

    <p>
        <?= Html::a('Изменить', ['update'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
