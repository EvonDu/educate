<?php

namespace api\modules\v1\controllers;

use api\lib\ApiController;

/**
 * @OA\Info(title="API文档", version="1.0", description="接口文档", @OA\Contact(email="duyufeng@thybot.com"))
 * @OA\Server(description="",url=API_HOST)
 * @OA\Server(description="IP",url="http://47.244.63.58/educate/advanced/api/web")
 * @OA\Server(description="域名1",url="http://api.link-en.com")
 * @OA\Server(description="域名2",url="http://api.e-l.ink")
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
    }
}
