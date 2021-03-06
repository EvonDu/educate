<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2advanced',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
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
    ],
];
