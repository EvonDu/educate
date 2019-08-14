<?php
namespace api\modules\v2\controllers;

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
        $result = Yii::$app->mailer->compose()
            ->setFrom("evon_auto@163.com")
            ->setTo(["evon1991@163.com"])
            ->setSubject('Message subject')
            ->setTextBody('Plain text content')
            ->setHtmlBody('<b>HTML content</b>')
            ->send();

        //返回结果
        return $result;
    }
}
