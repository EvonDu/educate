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
    public $depends = [];
}