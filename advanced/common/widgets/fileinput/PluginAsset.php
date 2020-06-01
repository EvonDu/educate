<?php
namespace common\widgets\fileinput;

use yii\web\AssetBundle;

class PluginAsset extends AssetBundle //需要继承AssetBundle类
{
    public $sourcePath = '@common/widgets/fileinput/assets';

    //定义资源包的css
    public $css = [
        'css/image-input.css',
        'css/images-input.css',
        'css/file-input.css',
        'css/video-input.css',
    ];
    //定义资源包的js
    public $js = [
        'js/ajaxfileupload-compatible.js',
        'js/ajaxfileupload.js',
        'js/image-input.js',
        'js/images-input.js',
        'js/file-input.js',
        'js/video-input.js',
    ];
    //定义资源包的依赖
    public $depends = [
        //'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',         //依赖Bootstrap
        'yii\web\JqueryAsset',                  //依赖jquery
    ];
}