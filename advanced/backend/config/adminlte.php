<?php
use \yii\helpers\Url;

return [
    //配置名称
    'productName' => 'YII Admin 3',
    //配置用户
    'user' => [
        'name'=> isset(Yii::$app->user->identity->info->nickname) ? Yii::$app->user->identity->info->nickname : null,
        'image'=> isset(Yii::$app->user->identity->info->avatarUrl) ? Yii::$app->user->identity->info->avatarUrl : null,
        'job'=> "开发者",
        'abstract'=> 'PHP后端开发者',
    ],
    //用户按钮
    'userButtons' => [
        [ 'text' => '用户信息', 'url' => Url::to(["user/admin/view","id"=>Yii::$app->user->id]) ],
        [ 'text' => '修改密码', 'url' => Url::to(["user/admin/change-password"]) ],
        [ 'text' => '系统主页', 'url' => Url::home() ],
    ],
    //配置简介
    'profile' => [ 'text' => '设置', 'url' => Url::to(["user/admin/info","id"=>Yii::$app->user->id]) ],
    //配置登出
    'signout' => [ 'text' => '退出', 'url' => Url::to(["site/logout"]) ],
    //配置导航
    'nav' => backend\nav\Nav::getNav(),
    //配置页脚
    'footer' => '<strong>Copyright &copy; 2017-2018 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights reserved.',
];