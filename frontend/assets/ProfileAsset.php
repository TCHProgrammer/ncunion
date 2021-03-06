<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class ProfileAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        //'js/libscripts.bundle.js',
        'js/vendorscripts.bundle.js',
        'js/jvectormap.bundle.js',
        'js/morrisscripts.bundle.js',
        'js/sparkline.bundle.js',
        'js/knob.bundle.js',
        'js/mainscripts.bundle.js',
        'js/index.js',
        'js/jquery-knob.min.js',
        //'//cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.2/bootstrap-slider.min.js',
        'js/ion.rangeSlider.min.js',
        'js/owl.carousel.min.js',
        'js/lightbox/lightbox.min.js',
        'js/script-user.js'
    ];
    public $css = [
        '//fonts.googleapis.com/icon?family=Material+Icons',
        'css/jquery-jvectormap-2.0.3.css',
        //'//cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.2/css/bootstrap-slider.min.css',
        'css/morris.css',
        'css/bootstrap-select.min.css',
        'css/main.css',
        'css/ecommerce.css',
        'css/color_skins.css',
        'css/ion.rangeSlider.css',
        'css/ion.rangeSlider.skinFlat.css',
        'css/owl.carousel/owl.carousel.min.css',
        'css/owl.carousel/owl.theme.default.css',
        'css/lightbox.min.css',
        'css/site-admin.css'
    ];
    public $cssOptions = [
        'type' => 'text/css',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}