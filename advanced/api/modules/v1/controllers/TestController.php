<?php
namespace api\modules\v1\controllers;

use api\lib\ApiController;

/**
 * !!!!!@SWG\Tag(name="Test",description="测试")
 */
class TestController extends ApiController
{
    public $modelClass = 'common\models\user\User';

    public function actions()
    {
        return [];
    }
}