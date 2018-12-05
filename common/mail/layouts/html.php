<?php
use yii\helpers\Html;
use common\models\InfoSite;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
$model = InfoSite::findOne(1);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="background: #fff; min-width: 340px; line-height: normal;">
        <tr>
            <td align="center" valign="top">
                <table class="email-fon" border="0" style="width:90%">
                    <tbody class="email-head" style="background: #424b5f;color:#fff" >
                        <tr>
                            <td align="center" colspan="2" style="padding:15px 15px 5px 15px">
                                <p><?= $model->title ?></p>
                            </td>
                        </tr>
                    </tbody>
                    <tbody style="background-color:#4f5a6e;color:#fff">
                        <tr>
                            <td colspan="2" style="padding:30px 30px 20px 30px;background-color:#4f5a6e;color:#fff!important;">
                                <?= $content ?>
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="email-foot" style="background-color:#424b5f;color:#fff; border: 5px double #000;">
                        <tr>
                            <td align="left" style="padding:30px 30px 15px 30px">
                                <p>© Национальный Кредитный Союз <?= date('Y') ?></p>
                            </td>
                            <td align="right" style="padding:20px 20px 10px 20px;color:#fff">
                                <p>Телефон: <?= $model->letter_phone ?></p>
                                <?php /* TODO: Return letter_email model in future */ ?>
                                <p style="color:#9db7ff">Почта: <a href="mailto:info@zalogzalog.ru">info@zalogzalog.ru</a></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
