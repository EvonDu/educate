<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'modules' => [
        'v1' => [
            'class' => 'api\modules\v1\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
        ],
        'user' => [
            'identityClass' => 'common\models\user\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the api
            'name' => 'advanced-api',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                //用户
                [
                    'class' => 'yii\rest\UrlRule',
                    'pluralize' => false,
                    'controller' => ['v1/users'],
                    'extraPatterns' => [
                        'GET <id:\d+>' => 'view',
                        'POST courses' => 'courses-create',
                        'DELETE courses' => 'courses-delete',
                        'POST login' => 'login',
                    ],
                ],
                //公共
                [
                    'class' => 'yii\rest\UrlRule',
                    'pluralize' => false,
                    'controller' => ['v1/upload'],
                    'extraPatterns' => [
                        'GET get/<src:.*>' => 'get',
                    ],
                ],
                //媒体
                [
                    'class' => 'yii\rest\UrlRule',
                    'pluralize' => false,
                    'controller' => ['v1/medias'],
                    'extraPatterns' => [
                        'GET pronunciations/<word:\w+>' => 'pronunciations',
                    ],
                ],
                //教师
                [
                    'class' => 'yii\rest\UrlRule',
                    'pluralize' => false,
                    'controller' => ['v1/instructors'],
                    'extraPatterns' => [
                        'GET ' => 'index',
                        'GET <id:\d+>' => 'view',
                    ],
                ],
                //课程
                [
                    'class' => 'yii\rest\UrlRule',
                    'pluralize' => false,
                    'controller' => ['v1/courses'],
                    'extraPatterns' => [
                        'GET ' => 'index',
                        'GET hash' => 'hash',
                        'GET <course_num:\w+>' => 'view',
                        'GET lessons/<id:\d+>' => 'lessons',
                    ],
                ],
                //作业
                [
                    'class' => 'yii\rest\UrlRule',
                    'pluralize' => false,
                    'controller' => ['v1/tasks'],
                    'extraPatterns' => [
                        'GET submits' => 'submits-view',
                        'POST submits' => 'submits-create',
                        'GET user/<task_id:\d+>' => 'user-view',
                    ],
                ],
                //收藏
                [
                    'class' => 'yii\rest\UrlRule',
                    'pluralize' => false,
                    'controller' => ['v1/favorites'],
                    'extraPatterns' => [
                        'POST ' => 'create',
                        'DELETE ' => 'delete',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];
