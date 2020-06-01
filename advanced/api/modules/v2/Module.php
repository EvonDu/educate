<?php

namespace api\modules\v2;

use yii\base\BootstrapInterface;

/**
 * v1 module definition class
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'api\modules\v2\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    /**
     * @param \yii\base\Application $app
     */
    public function bootstrap($app){
        $rules = $this->rules();
        $app->getUrlManager()->addRules($rules);
    }

    /**
     * @inheritdoc
     */
    public function rules(){
        return [
            //用户模块
            'POST       v2/users'                           => 'v2/users/create',
            'GET        v2/users/<id:\d+>'                  => 'v2/users/view',
            'PUT        v2/users/<id:\d+>'                  => 'v2/users/update',
            'PUT        v2/users/<id:\d+>/password'         => 'v2/users/update-password',
            'POST       v2/users/check-login'               => 'v2/users/check-login',
            'POST       v2/users/captcha/email'             => 'v2/users/captcha-email',
            'POST       v2/users/captcha/read'              => 'v2/users/captcha-read',
            'GET        v2/users/<id:\d+>/point'            => 'v2/users/point',
            'POST       v2/users/<id:\d+>/point'            => 'v2/users/point-change',
            //重置密码
            'POST       v2/users/captcha/reset'             => 'v2/users/captcha-reset',
            'POST       v2/users/password/reset'            => 'v2/users/reset-password',
            //课程模块
            'POST       /v2/courses/<course_id:\d+>/redeem' => 'v2/courses/redeem',
            //大客户模块
            'POST       customers/redeem'                   => 'v2/customers/redeem',
        ];
    }
}
