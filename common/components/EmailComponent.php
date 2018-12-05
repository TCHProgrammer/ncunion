<?php

namespace common\components;

use yii\base\Component;
use Yii;
use common\models\InfoSite;

class EmailComponent extends Component
{

    public $infoSite;

    public function init()
    {
        parent::init();
        $this->infoSite = InfoSite::find()->select(['title', 'letter_email', 'letter_phone'])->where(['id' => 1])->one();
    }

    /**
     * тестовая отправка сообщения
     */
    public function test($userTo)
    {
        Yii::$app->mailer->compose(['html' => 'test'], ['model' => $this->infoSite])
            ->setFrom($this->infoSite->letter_email)
            ->setTo($userTo)
            ->setSubject('Тестовое письмо')
            ->setTextBody('текст тестового письма')
            ->send();
    }

    /**
     * 1 этап регистрации (самая первая регистрация)
     */
    public function regUser($userTo, $contentMas)
    {
        Yii::$app->mailer->compose(['html' => 'regUser'], ['contentMas' => $contentMas])
            ->setFrom($this->infoSite->letter_email)
            ->setTo($userTo)
            ->setSubject('Вы успешно зарегистрировались на ' . $this->infoSite->title)
            ->send();
    }

    /**
     * подстверждения email
     */
    public function checkEmailUser($userTo, $contentMas)
    {
        if (
        Yii::$app->mailer->compose(['html' => 'checkEmailUser'], ['contentMas' => $contentMas])
            ->setFrom($this->infoSite->letter_email)
            ->setTo($userTo)
            ->setSubject('Подтвердите адрес электроннно почты')
            ->send()
        ) {
            return true;
        }
    }

    public function checkModerate($userTo, $contentMas)
    {
        Yii::$app->mailer->compose(['html' => 'checkModerate'], ['contentMas' => $contentMas])
            ->setFrom($this->infoSite->letter_email)
            ->setTo($userTo)
            ->setSubject('Модерация завершена')
            ->send();
    }

    public function subscribeObject($userTo, $objectTitle)
    {
        Yii::$app->mailer->compose()
            ->setFrom($this->infoSite->letter_email)
            ->setTo($userTo)
            ->setSubject('Вы подписаны')
            ->setTextBody("Спасибо за оставленную заявку на объект \"{$objectTitle}\". В ближайшее время решение будет принято.")
            ->send();
    }

    public function acceptSubscribeObject($userTo, $objectTitle)
    {
        Yii::$app->mailer->compose()
            ->setFrom($this->infoSite->letter_email)
            ->setTo($userTo)
            ->setSubject('Заявка принята.')
            ->setTextBody("Ваша заявка на объект \"{$objectTitle}\" принята.")
            ->send();
    }

    public function declineSubscribeObject($userTo, $objectTitle)
    {
        Yii::$app->mailer->compose()
            ->setFrom($this->infoSite->letter_email)
            ->setTo($userTo)
            ->setSubject('Заявка отклонена.')
            ->setTextBody("Ваша заявка на объект \"{$objectTitle}\" отклонена.")
            ->send();
    }

    public function takeAwayObject($userTo, $objectTitle)
    {
        Yii::$app->mailer->compose()
            ->setFrom($this->infoSite->letter_email)
            ->setTo($userTo)
            ->setSubject('Срочное уведомление.')
            ->setTextBody("Здравствуйте. Благодарим за работу в нашей системе. На данный момент вы не являетесь инвестором обьекта \"{$objectTitle}\".")
            ->send();
    }
    public function unsubscribeObject($userTo, $objectTitle)
    {
        Yii::$app->mailer->compose()
            ->setFrom($this->infoSite->letter_email)
            ->setTo($userTo)
            ->setSubject('Вы отписались')
            ->setTextBody("Вы отписались от объекта \"{$objectTitle}\".")
            ->send();
    }

    /**
     * 2 этап регистрации (регистрация паспорта)
     */
    public function regPassport($userTo)
    {
        Yii::$app->mailer->compose()
            ->setTo($userTo)
            ->setFrom($this->infoSite->letter_email)
            ->setSubject('Вы успешно создали свой паспорт')
            ->setTextBody('text письма')
            ->send();
    }

    public function regPhone($userTo)
    {
        Yii::$app->mailer->compose()
            ->setTo($userTo)
            ->setFrom($this->infoSite->letter_email)
            ->setSubject('Вы успешно подтвердили номер телефона')
            ->setTextBody('Благодарим Вас за подтверждение номера телефона. Доступ к сервису будет открыт после модерации. Спасибо за ожидание.')
            ->send();
    }

    /**
     * Восстановление пароля
     */
    public function passwordResetToken($userTo, $user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom($this->infoSite->letter_email)
            ->setTo($userTo)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
    }

}
