<?php
namespace api\modules\v1\controllers;

use common\models\user\User;
use Yii;
use yii\helpers\ArrayHelper;
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
     * 课程列表
     * @OA\Get(
     *      path="/v1/courses",
     *      tags={"Course"},
     *      summary="课程列表",
     *      description="获取所有课程列表(所有字段均可作为参数作模糊查询)",
     *      @OA\Parameter(name="page", required=false, in="query",description="分页", @OA\Schema(type="integer")),
     *      @OA\Parameter(name="pageSize", required=false, in="query",description="查询数量", @OA\Schema(type="integer")),
     *      @OA\Parameter(name="type_id", required=false, in="query",description="课程类型ID", @OA\Schema(type="integer")),
     *      @OA\Parameter(name="instructor_id", required=false, in="query",description="课程导师ID", @OA\Schema(type="integer")),
     *      @OA\Parameter(name="name", required=false, in="query",description="课程名称(模糊查询)", @OA\Schema(type="string")),
     *      @OA\Parameter(name="level", required=false, in="query",description="课程难度", @OA\Schema(type="string")),
     *      @OA\Response(response="default", description="返回结果")
     * )
     */
    public function actionIndex(){
        //查询类
        $searchModel = new CourseSearch();
        $dataProvider = $searchModel->search_api(Yii::$app->request->queryParams);

        //设置分页
        $pagination = ApiRequest::injectionPage($dataProvider);

        //获取items
        $models = $dataProvider->getModels();
        $items = [];
        foreach ($models as $model){
            $item = [
                "num" => $model->num,
                "name" => $model->name,
                "name_en" => $model->name_en,
                "image" => $model->image,
                "price" => $model->price,
                "price_dollar" => $model->price_dollar,
                "type" => $model->type,
                "instructor" => $model->instructor,
                "level" => $model->level,
                "period" => $model->period,
                "synopsis"=>$model->synopsis,
                "synopsis_en"=>$model->synopsis_en,
            ];
            $items[] = $item;
        }

        //构建返回
        $result = array_merge($pagination,[
            "items" => $items
        ]);
        return $result;
    }

    /**
     * 课程详情
     * @OA\Get(
     *      path="/v1/courses/{num}",
     *      tags={"Course"},
     *      summary="课程详情",
     *      description="获取所有课程详细信息",
     *      @OA\Parameter(name="num", required=true, in="path",description="课程编号", @OA\Schema(type="string")),
     *      @OA\Response(response="default", description="返回结果")
     * )
     */
    public function actionView($course_num){
        //获取课程
        $model = Course::findOne(["num"=>$course_num]);
        if(!$model)
            throw new NotFoundHttpException("Not found:$course_num");

        //返回课程信息
        $result = ArrayHelper::toArray($model);
        $result["lessons"] = $model->getCourseLessonsAbstract();
        return $result;
    }

    /**
     * 课程详情
     * @OA\POST(
     *      path="/v1/courses/read",
     *      tags={"Course"},
     *      summary="读取课程",
     *      description="读取用户所拥有的课程",
     *      @OA\RequestBody(required=true, @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded", @OA\Schema(
     *              @OA\Property(description="用户ID", property="user_id", type="string"),
     *              @OA\Property(description="课程ID", property="course_id", type="string"),
     *          )
     *      )),
     *      @OA\Response(response="default", description="返回结果")
     * )
     */
    public function actionRead(){
        //参数检测
        ApiRequest::checkPost(["user_id","course_id"]);
        $user_id = Yii::$app->request->post("user_id");
        $course_id = Yii::$app->request->post("course_id");

        //获取课程拥有状态
        $has = UserCourse::findOne(["user_id"=>$user_id, "course_id"=>$course_id]);
        if(!$has)
            throw new NotFoundHttpException("users do not own courses id:$course_id");

        //返回课程信息
        $result["state"] = ["try"=>$has->try];
        $result["course"] = ArrayHelper::toArray($has->course);
        $result["course"]["lessons"] = $has->course->getCourseLessonsAbstract();
        return $result;
    }

    /**
     * 章节详情
     * @OA\Get(
     *      path="/v1/courses/lessons/{id}",
     *      tags={"Course"},
     *      summary="章节详情",
     *      description="获取章节的详细信息",
     *      @OA\Parameter(name="id", required=true, in="path",description="章节ID", @OA\Schema(type="integer")),
     *      @OA\Response(response="default", description="返回结果")
     * )
     */
    public function actionLessons($id){
        //查询
        $model = CourseLesson::findOne($id);
        if(!$model)
            throw new NotFoundHttpException("Not found:$id");

        //返回
        return $model;
    }

    /**
     * 课程试用
     * @OA\Post(
     *      path="/v1/courses/try",
     *      tags={"Course"},
     *      summary="课程试用",
     *      description="课程试用",
     *      @OA\RequestBody(required=true, @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded", @OA\Schema(
     *              @OA\Property(description="用户ID", property="user_id", type="string"),
     *              @OA\Property(description="课程ID", property="course_id", type="string"),
     *          )
     *      )),
     *      @OA\Response(response="default", description="返回结果"),
     * )
     */
    public function actionTry(){
        //参数检测
        ApiRequest::checkPost(["user_id","course_id"]);
        $user_id = Yii::$app->request->post("user_id");
        $course_id = Yii::$app->request->post("course_id");

        //调用试用
        $user_course = UserCourse::tryCourse($user_id, $course_id);

        //获取对象
        $user = User::findOne($user_id);
        $course = Course::findOne($course_id);

        //发送邮件
        Yii::$app->mailer->compose('template/try.php', ["user"=>$user,"course"=>$course,"user_course"=>$user_course])
            ->setFrom(Yii::$app->params["supportEmail"])
            ->setTo([$user->email])
            ->setSubject('i-Link 课程试用成功')
            ->send();

        //返回
        if($user_course)
            return null;
        else
            throw new ServerErrorHttpException("create try fail.");
    }

    /**
     * 课程购买
     * @OA\Post(
     *      path="/v1/courses/buy",
     *      tags={"Course"},
     *      summary="课程购买",
     *      description="课程购买",
     *      @OA\RequestBody(required=true, @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded", @OA\Schema(
     *              @OA\Property(description="用户ID", property="user_id", type="string"),
     *              @OA\Property(description="课程ID", property="course_id", type="string"),
     *          )
     *      )),
     *      @OA\Response(response="default", description="返回结果"),
     * )
     */
    public function actionBuy(){
        //参数检测
        ApiRequest::checkPost(["user_id","course_id"]);
        $user_id = Yii::$app->request->post("user_id");
        $course_id = Yii::$app->request->post("course_id");

        //购买课程
        $user_course = UserCourse::buyCourse($user_id, $course_id);

        //获取对象
        $user = User::findOne($user_id);
        $course = Course::findOne($course_id);

        //发送邮件
        Yii::$app->mailer->compose('template/try.php', ["user"=>$user,"course"=>$course,"user_course"=>$user_course])
            ->setFrom(Yii::$app->params["supportEmail"])
            ->setTo([$user->email])
            ->setSubject('i-Link 课程购买成功')
            ->send();

        //返回
        if($user_course)
            return null;
        else
            throw new ServerErrorHttpException("create try fail.");
    }

    /**
     * 判断用户课程状态
     * @OA\Get(
     *      path="/v1/courses/hash",
     *      tags={"Course"},
     *      summary="判断用户课程状态",
     *      description="判断用户课程状态（0：未拥有、1：已试用、2：已购买）",
     *      @OA\Parameter(name="user_id", required=true, in="query",description="用户ID", @OA\Schema(type="integer")),
     *      @OA\Parameter(name="course_id", required=true, in="query",description="课程ID", @OA\Schema(type="integer")),
     *      @OA\Response(response="default", description="返回结果")
     * )
     */
    public function actionHash(){
        //参数检测
        ApiRequest::checkGet(["user_id","course_id"]);
        $user_id = Yii::$app->request->get("user_id");
        $course_id = Yii::$app->request->get("course_id");

        //调用试用
        $model = UserCourse::findOne(["user_id"=>$user_id,"course_id"=>$course_id]);

        //判断是否拥有
        if(empty($model))
            return 0;

        //判断是否过期
        if($model->used_at < time())
            return 4;

        //返回
        return $model->try ? 1 : 2;
    }
}