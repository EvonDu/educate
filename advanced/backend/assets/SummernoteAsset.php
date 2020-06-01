<?php

namespace backend\assets;

use yii\web\AssetBundle;

class SummernoteAsset extends AssetBundle
{
    public $sourcePath = __DIR__.'/resource/summernote';
    public $css = [
        'summernote.css',
    ];
    public $js = [
        'summernote.min.js',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $cssOptions = [];
    public $depends = [
        'yii\web\JqueryAsset',                  //依赖jquery
        'yii\bootstrap\BootstrapAsset',         //依赖Bootstrap
        'yii\bootstrap\BootstrapPluginAsset',   //依赖BootstrapJs
    ];
}