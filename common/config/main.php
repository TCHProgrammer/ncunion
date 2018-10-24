<?php
return [
    'language' => 'ru-RU',
    //'sourceLanguage' =>'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'i18n' => [
            'translations' => [
                'eav' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@mirocow/eav/messages',
                ],
            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'thousandSeparator' => ' ',
            'decimalSeparator' => ',',
            /*'locale' => 'ru-RU',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'EUR',*/
            'datetimeFormat' => 'd MMMM Y, в H:i'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            //'cache' => 'cache' //Включаем кеширование
        ],
        'email' => [
            'class' => 'common\components\EmailComponent',
        ],
        'date' => [
            'class' => 'common\components\DateComponent',
        ],
        'cud' => [
            'class' => 'common\components\CudComponent',
        ],
        'zipper' => [
            'class' => 'Victor78\Zipper\Zipper',
            'type' => 'zip', //or 'zip' (default), 'tar', 'tar.gz', 'tar.bz2'
        ],
    ],

];
