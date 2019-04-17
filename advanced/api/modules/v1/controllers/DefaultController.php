<?php

namespace api\modules\v1\controllers;

use api\lib\ApiController;

/**
 * @SWG\Swagger(
 *     host={"192.168.1.12/github/educate/advanced/api/web"},
 *     schemes={"http","https"},
 *     consumes={"application/x-www-form-urlencoded","application/json"},
 *     produces={"application/json"},
 *     apiEnvs={
 *          { "name": "本地", "baseUrl": "http://localhost/github/educate/advanced/api/web", "sortWeight": 1, "mock": false, "status": "on"},
 *          { "name": "局域网", "baseUrl": "http://192.168.1.12/github/educate/advanced/api/web", "sortWeight": 2, "mock": false, "status": "on"},
 *          { "name": "服务器", "baseUrl": "http://47.244.63.58/educate/advanced/api/web", "sortWeight": 3, "mock": false, "status": "on"},
 *          { "name": "支付测试", "baseUrl": "http://prime.thylink.cn/test/educate/advanced/api/web", "sortWeight": 3, "mock": false, "status": "on"}
 *     }
 * ),
 * @SWG\Info(version="1.0",title="接口文档",description="接口相关的Swagger文档"),
 */
class DefaultController extends ApiController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return "Api V1";
        return $this->render('index');
    }
}
