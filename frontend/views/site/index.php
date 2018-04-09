<?php
$this->title = 'ZalogZalog';
?>
<div class="site-index">
    <?php
    var_dump($_SESSION);
    $session = Yii::$app->session;
    var_dump($session->isActive);
    var_dump('Yii::$app->user->id = ' . Yii::$app->user->id);
    var_dump( Yii::$app->authManager->getRolesByUser(Yii::$app->user->id));
    var_dump( Yii::$app->authManager->getPermissionsByUser(Yii::$app->user->id));
    var_dump( Yii::$app->user->can('canAdmin'));
    var_dump( Yii::$app->user->can('admin_menu_rbac_users'));
    var_dump( Yii::$app->user->can('widgetAdminPanel'));

    ?>

</div>
