<?php
use yii\helpers\Url;
$this->title = 'ZalogZalog';
use common\models\object\ObjectAttribute;
?>
<div class="site-index">
    <?php

    $modell = ObjectAttribute::find()
        ->where(['object_id' => 30])
        ->andWhere(['attribute_id' => 1])
        ->one();

    var_dump($modell);


    /*Yii::$app->mailer->compose()
        ->setFrom('test.test.37@yandex.ru')
        ->setTo('alexcpu7@gmail.com')
        ->setTextBody('dddd')
        ->send();

Yii::$app->mailer->compose()
    ->setTo('alexcpu7@gmail.com')
    ->setFrom([ 'test.test.37@yandex.ru'=> 'lox']) 	// выставить почту . Ту самую, от которой и настроена отправка в конфиге. У нас это admin@xxxxxx.ru.Если не выставить , то хана. Через яндекс не отправишь
    ->setTextBody('text письма')
    ->send();*/

    /*$email = new Email();
    if($email->test('alexcpu7@gmail.com')){
        var_dump('all good');
    }else{
        var_dump(':(');
    }

    var_dump((InfoSite::find()->select(['title', 'letter_email', 'letter_phone'])->where(['id' => 1])->one()));*/

    $mas = [
            'name' => 'alex',
        'link' => 'sssss'
    ];
    //Yii::$app->email->checkEmailUser('alexcpu7@gmail.com', $mas);
    //Yii::$app->email->checkEmailUser('alexcpu7@gmail.com', $mas);


    echo Url::toRoute(['/check-user/email', 'token' => 11111111])."<br>";
    echo Url::toRoute(['check-user/email', 'token' => 11111111])."<br>";
    echo Url::home()."<br>";
    echo Url::to(['check-user/email', 'token' => 11111111])."<br>";
    ?>

</div>




