<?php
use yii\helpers\Url;
$this->title = 'Подтверждение электронной почты';
?>

<h1><?= $this->title; ?></h1>

<?= $text ?>

<a href="<?= Url::toRoute('/user/profile'); ?>">Для дальнейшер работы перейдите в свой профиль</a>
