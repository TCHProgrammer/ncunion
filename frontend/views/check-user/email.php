<?php
use yii\helpers\Url;
$this->title = 'Подтверждение электронной почты';
?>

<?= $text ?>

<a href="<?= Url::toRoute('/user/profile'); ?>">Для дальнейшер работы перейдите в свой профиль</a>
