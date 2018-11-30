<?php
namespace api\modules\v1\controllers;

use common\models\course\Task;
use Yii;
use yii\helpers\Url;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;
use api\lib\ModelErrors;
use api\lib\ApiRequest;
use api\lib\ApiController;
use common\models\course\Course;
use common\models\course\CourseLesson;
use common\models\course\CourseSearch;
use common\models\user\UserCourse;

/**
 * @SWG\Definition(
 *     definition="Course",
 *     @SWG\Property(property="num",description="课程号",type="string"),
 *     @SWG\Property(property="price",description="课程价格",type="integer"),
 *     @SWG\Property(property="instructor_id",description="导师ID",type="integer"),
 *     @SWG\Property(property="type_id",description="分类ID",type="integer"),
 *     @SWG\Property(property="image",description="封面",type="string"),
 *     @SWG\Property(property="level",description="课程难度",type="integer"),
 *     @SWG\Property(property="abstract",description="课程简介",type="string"),
 *     @SWG\Property(property="content",description="课程内容",type="string"),
 *     @SWG\Property(property="requirements_prerequisites",description="课程要求-前提",type="string"),
 *     @SWG\Property(property="requirements_textbooks",description="课程要求-教科书",type="string"),
 *     @SWG\Property(property="requirements_software",description="课程要求-软件",type="string"),
 *     @SWG\Property(property="requirements_hardware",description="课程要求-硬件",type="string"),
 *     @SWG\Property(property="next_term_at",description="下学期开学时间",type="integer"),
 *     @SWG\Property(property="created_at",description="创建时间",type="integer"),
 *     @SWG\Property(property="updated_at",description="更新时间",type="integer"),
 * )
 */

/**
 * @SWG\Definition(
 *     definition="CourseLesson",
 *     @SWG\Property(property="id",description="ID",type="string"),
 *     @SWG\Property(property="course_id",description="课程ID",type="integer"),
 *     @SWG\Property(property="lesson",description="章节号",type="integer"),
 *     @SWG\Property(property="title",description="标题",type="string"),
 *     @SWG\Property(property="abstract",description="简介",type="string"),
 *     @SWG\Property(property="video",description="视频",type="string"),
 *     @SWG\Property(property="doc",description="课件",type="string"),
 *     @SWG\Property(property="created_at",description="创建时间（时间戳）",type="integer"),
 *     @SWG\Property(property="updated_at",description="更新时间（时间戳）",type="integer"),
 * )
 */

/**
 * @SWG\Tag(name="Course",description="课程")
 */
class CoursesController extends ApiController
{
    public $modelClass = 'common\models\course\Course';

    public function actions()
    {
        $parent = parent::actions();
        unset($parent["index"]);
        unset($parent["view"]);
        return $parent;
    }

    /**
     * 课程列表
     * @SWG\GET(
     *     path="/v1/courses",
     *     tags={"Course"},
     *     summary="课程列表",
     *     description="获取所有课程列表(所有字段均可作为参数作模糊查询)",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="page",type="integer", required=false, in="query",description="分页" ),
     *     @SWG\Parameter( name="pageSize",type="integer", required=false, in="query",description="查询数量" ),
     *     @SWG\Parameter( name="type_id",type="integer", required=false, in="query",description="课程类型ID" ),
     *     @SWG\Parameter( name="instructor_id",type="integer", required=false, in="query",description="课程导师ID" ),
     *     @SWG\Parameter( name="name",type="string", required=false, in="query",description="课程名称(模糊查询)" ),
     *     @SWG\Parameter( name="level",type="string", required=false, in="query",description="课程难度" ),
     *     @SWG\Response( response="return",description="课程列表")
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
                "image" => $model->image,
                "price" => $model->price,
                "type" => $model->type,
                "instructor" => $model->instructor,
                "level" => $model->level,
                "period" => $model->period,
                "synopsis"=>$model->synopsis,
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
     * @SWG\GET(
     *     path="/v1/courses/{num}",
     *     tags={"Course"},
     *     summary="课程详情",
     *     description="获取所有课程详细信息",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="num",type="string", required=false, in="path",description="课程编号" ),
     *     @SWG\Response( response="return",description="课程详情")
     * )
     */
    public function actionView($course_num){
        //获取课程
        $model = Course::findOne(["num"=>$course_num]);
        if(!$model)
            throw new NotFoundHttpException("Not found:$course_num");

        //获取课程所有章节
        $lessons = [];
        foreach ($model->courseLessons as $lesson){
            $item = [
                "id"=>$lesson->id,
                "lesson"=>$lesson->lesson,
                "title"=>$lesson->title,
                "abstract"=>$lesson->abstract,
                "try"=>$lesson->try,
                "free"=>$lesson->free,
            ];
            $lessons[] = $item;
        }

        //返回课程信息
        $result = ArrayHelper::toArray($model);
        $result["lessons"] = $lessons;
        return $result;
    }

    /**
     * 章节详情
     * @SWG\GET(
     *     path="/v1/courses/lessons/{id}",
     *     tags={"Course"},
     *     summary="章节详情",
     *     description="获取章节的详细信息",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="id",type="integer", required=true, in="path",description="章节ID" ),
     *     @SWG\Response( response="return",description="章节详情")
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
     * @SWG\POST(
     *     path="/v1/courses/try",
     *     tags={"Course"},
     *     summary="课程试用",
     *     description="课程试用",
     *     consumes={"application/x-www-form-urlencoded"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="user_id",type="integer", required=false, in="formData",description="用户ID" ),
     *     @SWG\Parameter( name="course_id",type="integer", required=false, in="formData",description="课程ID" ),
     *     @SWG\Response( response="return",description="返回信息")
     * )
     */
    public function actionTry(){
        //参数检测
        ApiRequest::checkPost(["user_id","course_id"]);
        $user_id = Yii::$app->request->post("user_id");
        $course_id = Yii::$app->request->post("course_id");

        //调用试用
        $bool = UserCourse::tryCourse($user_id, $course_id);

        //返回
        if($bool)
            return null;
        else
            throw new ServerErrorHttpException("create try fail.");
    }

    /**
     * 课程购买
     * @SWG\POST(
     *     path="/v1/courses/buy",
     *     tags={"Course"},
     *     summary="课程购买",
     *     description="课程购买",
     *     consumes={"application/x-www-form-urlencoded"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="user_id",type="integer", required=false, in="formData",description="用户ID" ),
     *     @SWG\Parameter( name="course_id",type="integer", required=false, in="formData",description="课程ID" ),
     *     @SWG\Response( response="return",description="返回信息")
     * )
     */
    public function actionBuy(){
        //参数检测
        ApiRequest::checkPost(["user_id","course_id"]);
        $user_id = Yii::$app->request->post("user_id");
        $course_id = Yii::$app->request->post("course_id");

        //购买课程
        $bool = UserCourse::buyCourse($user_id, $course_id);

        //返回
        if($bool)
            return null;
        else
            throw new ServerErrorHttpException("create try fail.");
    }

    /**
     * 判断用户课程状态
     * @SWG\GET(
     *     path="/v1/courses/hash",
     *     tags={"Course"},
     *     summary="判断用户课程状态",
     *     description="判断用户课程状态（0：未拥有、1：已试用、2：已购买）",
     *     consumes={"application/x-www-form-urlencoded"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="user_id",type="string", required=true, in="query",description="用户ID" ),
     *     @SWG\Parameter( name="course_id",type="string", required=true, in="query",description="课程ID" ),
     *     @SWG\Response( response="return",description="返回信息")
     * )
     */
    public function actionHash(){
        //参数检测
        ApiRequest::checkGet(["user_id","course_id"]);
        $user_id = Yii::$app->request->get("user_id");
        $course_id = Yii::$app->request->get("course_id");

        //调用试用
        $model = UserCourse::findOne(["user_id"=>$user_id,"course_id"=>$course_id]);

        //返回
        if(empty($model))
            return 0;
        else if($model->try)
            return 1;
        else
            return 2;
    }

    /**
     * 作业列表
     * @SWG\GET(
     *     path="/v1/courses/tasks",
     *     tags={"Course"},
     *     summary="作业列表",
     *     description="user_id和lesson_id不能同时为空",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="user_id",type="integer", required=false, in="query",description="用户ID" ),
     *     @SWG\Parameter( name="lesson_id",type="integer", required=false, in="query",description="章节ID" ),
     *     @SWG\Parameter( name="status",type="integer", required=false, in="query",description="状态(1：未回复，2：已回复)" ),
     *     @SWG\Response( response="return",description="作业列表")
     * )
     */
    public function actionTasks(){
        //获取参数
        $user_id = YII::$app->request->get("user_id",null);
        $lesson_id = YII::$app->request->get("lesson_id",null);
        $state = YII::$app->request->get("status",null);
        if(empty($user_id) && empty($lesson_id))
            throw new BadRequestHttpException("[user_id] and [lesson_id] can not be empty at the same time");

        //查询并返回
        $list = Task::getTasks($user_id,$lesson_id,$state);
        return $list;
    }

    /**
     * 作业详情
     * @SWG\GET(
     *     path="/v1/courses/tasks/{id}",
     *     tags={"Course"},
     *     summary="作业详情",
     *     description="",
     *     consumes={"application/x-www-form-urlencoded"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="id",type="integer", required=true, in="path",description="作业ID" ),
     *     @SWG\Response( response="return",description="作业详情")
     * )
     */
    public function actionTask($id){
        $model = Task::findOne($id);
        if(empty($model))
            throw new BadRequestHttpException("not found:[$id]");
        return $model;
    }

    /**
     * 作业提交
     * @SWG\POST(
     *     path="/v1/courses/tasks",
     *     tags={"Course"},
     *     summary="作业提交",
     *     description="",
     *     consumes={"application/x-www-form-urlencoded"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="user_id",type="integer", required=true, in="formData",description="用户ID" ),
     *     @SWG\Parameter( name="lesson_id",type="integer", required=true, in="formData",description="章节ID" ),
     *     @SWG\Parameter( name="content",type="string", required=true, in="formData",description="提交内容" ),
     *     @SWG\Response( response="return",description="作业ID")
     * )
     */
    public function actionTaskSubmit(){
        //获取参数
        ApiRequest::checkPost(["user_id", "lesson_id", "content"]);
        $user_id = Yii::$app->request->post("user_id");
        $lesson_id = Yii::$app->request->post("lesson_id");
        $content = Yii::$app->request->post("content");

        //获取作业
        $model = new Task();
        $model->user_id = $user_id;
        $model->lesson_id = $lesson_id;
        $model->content = $content;
        $model->submit_at = time();
        if($model->save())
            return $model->id;
        else
            throw new ServerErrorHttpException(ModelErrors::getError($model));
    }
}