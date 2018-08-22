<?php

namespace api\modules\v1\controllers;

use yii\web\Controller;

/**
 * @SWG\Swagger(
 *     host="localhost/yii-admin2/advanced/api/web",
 *     schemes={"http"},
 *     consumes={"application/json"},
 *     produces={"application/json"},
 * ),
 * @SWG\Info(version="1.0",title="接口文档",description="接口相关的Swagger文档"),
 */
class DefaultController extends Controller
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
