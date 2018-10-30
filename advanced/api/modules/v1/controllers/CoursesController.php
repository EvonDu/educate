<?php
namespace api\modules\v1\controllers;

use api\lib\ApiRequest;
use common\models\course\Course;
use common\models\course\CourseLesson;
use common\models\course\CourseSearch;
use common\models\course\CourseTypeSearch;
use common\models\instructor\Instructor;
use common\models\media\Pronunciation;
use common\models\user\UserCourse;
use Yii;
use yii\helpers\Url;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;
use api\lib\ModelErrors;

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
class CoursesController extends ActiveController
{
    public $modelClass = 'common\models\course\Course';

    public function behaviors()
    {
        return ArrayHelper::merge([
            //配置跨域
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                ],
            ],
        ], parent::behaviors());
    }

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
}