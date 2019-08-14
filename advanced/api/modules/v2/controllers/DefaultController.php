<?php
namespace api\modules\v1\controllers;

use api\lib\ApiController;

/**
 * @OA\Info(title="API文档", version="2.0", description="接口文档", @OA\Contact(email="duyufeng@thybot.com"))
 * @OA\Server(description="",url=API_HOST)
 */
class DefaultController extends ApiController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return "Api V2";
    }
}
