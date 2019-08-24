<?php
namespace api\modules\v2\controllers;

use common\models\user\UserCourse;
use Yii;
use api\lib\ApiController;

/**
 * @OA\Tag(name="Test",description="测试")
 */
class TestController extends ApiController
{
    /**
     * @return array
     */
    public function actions()
    {
        return [];
    }

    /**
     * 测试接口
     * @OA\Get(
     *      path="/v2/test",
     *      tags={"Test"},
     *      summary="测试接口",
     *      description="测试接口",
     *      @OA\Response(response="default", description="返回结果")
     * )
     */
    public function actionIndex()
    {
        //发送邮件
        $model = UserCourse::findOne(["user_id"=>1,"course_id"=>1]);
        $model->refreshProgress();

        //返回结果
        return $model;
    }
}
