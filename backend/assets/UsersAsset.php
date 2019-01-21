<?php


namespace backend\assets;

use yii\web\AssetBundle;

class UsersAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/users/script.js'
    ];
    public $depends = [
        'backend\assets\AppAsset',
    ];
}
