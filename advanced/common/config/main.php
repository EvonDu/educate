<?php
return [
    'language'=>'zh-CN',            //设置语言
    'timeZone' => 'Asia/Shanghai',  //设置时区
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        //缓存组件
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        //启用RBAC
        'authManager'=>[
            'class'=>'yii\rbac\DbManager',
            'itemTable' => 'auth_item',
            'assignmentTable' => 'auth_assignment',
            'itemChildTable' => 'auth_item_child',
        ],
        //邮箱组件(注意会被main-local的配置覆盖)
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => true,
            'transport' => [
                'class'         => 'Swift_SmtpTransport',
                'host'          => 'smtp.163.com',
                'username'      => '*******',
                'password'      => '*******',
                'port'          => '25',
                'encryption'    => 'tls',
            ],
        ],
        //七牛组件
        'qiniu' => [
            'class'=>'common\components\QiniuComponent'
        ],
    ],
];
