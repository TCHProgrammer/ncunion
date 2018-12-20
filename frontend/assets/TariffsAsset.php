<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class TariffsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [

    ];
    public $css = [
        'css/tariffs.css'
    ];
    public $cssOptions = [
        'type' => 'text/css',
    ];
    public $depends = [
        'frontend\assets\AppAsset',
    ];
}