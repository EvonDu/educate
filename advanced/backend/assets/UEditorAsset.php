<?php

namespace backend\assets;

use yii\web\AssetBundle;

class UEditorAsset extends AssetBundle
{
    public $sourcePath = __DIR__.'/resource/ueditor';
    public $js = [
        'ueditor.config.js',
        'ueditor.all.js',
        'lang/zh-cn/zh-cn.js',
    ];
    public $css = [
        'adjust.css',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $depends = [
        'yii\web\JqueryAsset',                  //依赖jquery
        'yii\bootstrap\BootstrapAsset',         //依赖Bootstrap
        'yii\bootstrap\BootstrapPluginAsset',   //依赖BootstrapJs
    ];
}