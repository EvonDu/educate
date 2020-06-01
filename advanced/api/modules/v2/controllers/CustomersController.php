<?php
namespace api\modules\v2\controllers;

use api\lib\ApiController;
use api\lib\ApiRequest;
use common\models\customer\CustomerCode;
use common\models\user\User;
use yii\web\BadRequestHttpException;

/**
 * @SWG\Tag(name="Customer",description="大客户")
 */
class CustomersController extends ApiController
{
    /**
     * 课程兑换
     * @OA\Post(
     *      path="/v2/customers/redeem",
     *      tags={"Customer"},
     *      summary="课程兑换",
     *      description="使用兑换码,兑换课程",
     *      @OA\RequestBody(required=true, @OA\MediaType(
     *          mediaType="application/json", @OA\Schema(
     *              @OA\Property(description="用户ID", property="user_id", type="integer"),
     *              @OA\Property(description="兑换码", property="code", type="string"),
     *              example={"user_id":1, "code":"5d65dd4ad80e06036"}
     *          )
     *      )),
     *      @OA\Response(response="default", description="返回结果"),
     * )
     */
    public function actionRedeem(){
        //参数检测
        $params = ApiRequest::getJsonParams(["user_id","code"]);

        //获取用户信息
        $user = User::findOne($params->user_id);
        if(empty($user))
            throw new BadRequestHttpException("找不到相关用户");

        //获取兑换码信息
        $code = CustomerCode::findOne(["code"=>$params->code]);
        if(empty($code))
            throw new BadRequestHttpException("兑换码无效");

        //进行兑换
        try{
            $code->redeem($user->id);
        }catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        //记录用户所属客户
        $user->customer = $code->customer->name;
        $user->save();

        //返回结果
        return true;
    }
}
