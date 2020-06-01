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
            'htmlLayout' => '@common/mail/layouts/i-link',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class'         => 'Swift_SmtpTransport',
                'host'          => 'smtp.mxhichina.com',
                'username'      => 'info@e-l.ink',
                'password'      => 'JuEarl83',
                'port'          => '465',
                'encryption'    => 'ssl',
            ],
        ],
        //七牛组件
        'qiniu' => [
            'class'=>'common\components\QiniuComponent'
        ],
    ],
];
