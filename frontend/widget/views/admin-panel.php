<?php
use yii\helpers\Url;
?>

<div class="admin-panel">
    <div class="admin-panel-block1">
        <ul>
            <li>
                <a href="<?= Url::toRoute('/admin') ?>" style="background: url(<?= Url::to('@web/img/adminPanel/settings.png') ?>) no-repeat center">Админка</a>
            </li>
            <li>
                <a href="<?= Url::toRoute('/admin-panel/cache') ?>"  style="background: url(<?= Url::to('@web/img/adminPanel/cache.png') ?>) no-repeat center">Сбросить кеш</a>
            </li>
        </ul>
    </div>
</div>