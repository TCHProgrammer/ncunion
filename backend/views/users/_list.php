

<div class="user-moder">
    <div class="user-moder-avatar">
        <img src="/uploads/other/default-avatar.png" />
    </div>
    <div class="user-moder-name">
        <div class="user-moder-fio"><?= $model->last_name . ' ' . $model->first_name  . ' ' . $model->middle_name ?></div>
        <div class="user-moder-compani"><?= $model->company_name ?></div>
    </div>
    <div class="user-moder-email-phone">
        <div class="user-moder-email">

        </div>
        <div class="user-moder-phone">

        </div>
    </div>
    <div class="user-moder-btn">
        <input type="button" class="" value="Подтвердить">
        <input type="button" value="Заблокировать" >
    </div>
</div>