<?php
namespace api\modules\v1\controllers;

use common\models\task\Task;
use common\models\task\TaskSubmit;
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

/**
 * @SWG\Tag(name="Task",description="作业")
 */
class TasksController extends ApiController
{
    public $modelClass = 'common\models\task\Task';

    public function actions()
    {
        $parent = parent::actions();
        unset($parent["index"]);
        unset($parent["view"]);
        return $parent;
    }

    /**
     * 作业列表
     * @SWG\GET(
     *     path="/v1/tasks",
     *     tags={"Task"},
     *     summary="作业列表",
     *     description="获取所有作业列表",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="course_id",type="integer", required=false, in="query",description="课程ID" ),
     *     @SWG\Parameter( name="lesson_id",type="integer", required=false, in="query",description="章节ID(必须与课程ID配合使用)" ),
     *     @SWG\Response( response="return",description="作业列表")
     * )
     */
    public function actionIndex(){
        //获取参数
        $course_id = YII::$app->request->get("course_id",null);
        $lesson_id = YII::$app->request->get("lesson_id",null);
        if((empty($course_id) && !empty($lesson_id)))
            throw new BadRequestHttpException("miss params [$course_id]");

        //查询并返回
        $list = Task::getTasks($course_id,$lesson_id);
        return $list;
    }

    /**
     * 作业详情
     * @SWG\GET(
     *     path="/v1/tasks/{id}",
     *     tags={"Task"},
     *     summary="作业详情",
     *     description="作业详情",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="id",type="string", required=true, in="path",description="作业ID" ),
     *     @SWG\Response( response="return",description="作业详情")
     * )
     */
    public function actionView($id){
        //获取课程
        $model = Task::findOne($id);
        if(!$model)
            throw new NotFoundHttpException("Not found:$id");

        //返回作业内容
        return $model;
    }

    /**
     * 学生提交作业
     * @SWG\POST(
     *     path="/v1/tasks/submits",
     *     tags={"Task"},
     *     summary="提交作业",
     *     description="提交作业",
     *     consumes={"application/x-www-form-urlencoded"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="task_id",type="string", required=true, in="formData",description="作业ID" ),
     *     @SWG\Parameter( name="user_id",type="string", required=true, in="formData",description="学生ID" ),
     *     @SWG\Parameter( name="submit_content",type="string", required=true, in="formData",description="提交内容" ),
     *     @SWG\Parameter( name="submit_file",type="string", required=false, in="formData",description="提交文件" ),
     *     @SWG\Parameter( name="submit_audio",type="string", required=false, in="formData",description="提交音频" ),
     *     @SWG\Response( response="return",description="提交ID")
     * )
     */
    public function actionSubmitsCreate(){
        //获取参数
        ApiRequest::checkPost(["task_id","user_id","submit_content"]);
        $task_id = Yii::$app->request->post("task_id");
        $user_id = Yii::$app->request->post("user_id");
        $submit_content = Yii::$app->request->post("submit_content");
        $submit_file = Yii::$app->request->post("submit_file",null);
        $submit_audio = Yii::$app->request->post("submit_audio",null);

        //保存到新对象
        $model = new TaskSubmit();
        $model->task_id = $task_id;
        $model->user_id = $user_id;
        $model->submit_content = $submit_content;
        $model->submit_file = $submit_file;
        $model->submit_audio = $submit_audio;
        if($model->save())
            return $model->id;
        else
            throw new ServerErrorHttpException(ModelErrors::getError($model));
    }

    /**
     * 提交详情
     * @SWG\GET(
     *     path="/v1/tasks/submits",
     *     tags={"Task"},
     *     summary="提交详情",
     *     description="作业提交的详情",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="task_id",type="string", required=true, in="query",description="作业ID" ),
     *     @SWG\Parameter( name="user_id",type="string", required=true, in="query",description="学生ID" ),
     *     @SWG\Response( response="return",description="作业信息")
     * )
     */
    public function actionSubmitsView(){
        //获取参数
        ApiRequest::checkGet(["task_id","user_id"]);
        $task_id = Yii::$app->request->get("task_id");
        $user_id = Yii::$app->request->get("user_id");

        //获取提交作业
        $model = TaskSubmit::getSubmit($task_id,$user_id);
        if($model)
            return $model;
        else
            throw new NotFoundHttpException("not found submit");
    }

    /**
     * 作业列表(根据用户ID)
     * @SWG\GET(
     *     path="/v1/tasks/user",
     *     tags={"Task"},
     *     summary="作业列表",
     *     description="作业列表(含用户状态)",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="user_id",type="string", required=true, in="query",description="学生ID" ),
     *     @SWG\Parameter( name="course_id",type="integer", required=false, in="query",description="课程ID" ),
     *     @SWG\Parameter( name="lesson_id",type="integer", required=false, in="query",description="章节ID" ),
     *     @SWG\Response( response="return",description="作业列表")
     * )
     */
    public function actionUser(){
        //获取参数
        ApiRequest::checkGet(["user_id"]);
        $user_id = YII::$app->request->get("user_id");
        $course_id = YII::$app->request->get("course_id",null);
        $lesson_id = YII::$app->request->get("lesson_id",null);
        if((empty($course_id) && !empty($lesson_id)))
            throw new BadRequestHttpException("miss params [$course_id]");

        //查询并返回
        $list = Task::getUserTasks($user_id,$course_id,$lesson_id);
        return $list;
    }

    /**
     * 作业详情(根据用户ID)
     * @SWG\GET(
     *     path="/v1/tasks/user/{task_id}",
     *     tags={"Task"},
     *     summary="作业详情",
     *     description="作业详情(含用户状态)",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="task_id",type="integer", required=true, in="path",description="作业ID" ),
     *     @SWG\Parameter( name="user_id",type="string", required=true, in="query",description="学生ID" ),
     *     @SWG\Response( response="return",description="作业列表")
     * )
     */
    public function actionUserView($task_id){
        //获取参数
        ApiRequest::checkGet(["user_id"]);
        $user_id = YII::$app->request->get("user_id");

        //获取作业信息
        $task = Task::findOne($task_id);
        if(!$task)
            throw new NotFoundHttpException("Not found:$task_id");

        //获取用户提交的作业情况
        $submit = TaskSubmit::getSubmit($task_id,$user_id);

        //返回
        return [
            "task" => $task,
            "submit" => $submit
        ];
    }
}