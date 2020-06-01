<?php
namespace api\modules\v2\controllers;

use common\models\user\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use api\lib\ApiRequest;
use api\lib\ApiController;
use common\models\user\UserCourse;
use common\models\course\Task;
use common\models\course\Course;
use common\models\course\CourseLesson;
use common\models\course\CourseSearch;

/**
 * @OA\Tag(name="Course",description="课程")
 */
class CoursesController extends ApiController
{
    public $modelClass = 'common\models\course\Course';

    /**
     * @return array
     */
    public function actions()
    {
        $parent = parent::actions();
        unset($parent["index"]);
        unset($parent["view"]);
        return $parent;
    }

    /**
     * 兑换课程
     * @OA\Post(
     *      path="/v2/courses/{course_id}/redeem",
     *      tags={"Course"},
     *      summary="兑换课程",
     *      description="使用积分兑换课程",
     *      @OA\Parameter(name="course_id", required=true, in="path",description="课程ID", @OA\Schema(type="integer",default="1")),
     *      @OA\RequestBody(required=true, @OA\MediaType(
     *          mediaType="application/json", @OA\Schema(
     *              @OA\Property(description="用户ID", property="user_id", type="string"),
     *              example={"user_id":1}
     *          )
     *      )),
     *      @OA\Response(response="default", description="返回结果"),
     * )
     */
    public function actionRedeem($course_id){
        //获取参数
        $params = ApiRequest::getJsonParams(['user_id']);
        $user_id = $params->user_id;

        //获取用户积分
        $user = User::findOne($user_id);
        if(empty($user))
            throw new BadRequestHttpException("not found user");

        //获取相关课程
        $course = Course::findOne($course_id);
        if(empty($course))
            throw new BadRequestHttpException("not found course");

        //获取兑换课程所需积分
        $point = ($course->price * 0.01) * 100;

        //判断积分是否充足
        $user_point = $user->deriveUserPoint();
        if($user_point->total < $point)
            throw new BadRequestHttpException("insufficient points");

        //兑换课程
        $bool = UserCourse::buyCourse($user_id, $course_id);

        //扣除积分
        $user_point->changePoint(-$point, "积分兑换课程");

        //返回
        return $bool ? "SUCCESS" : "FAIL";
    }
}