<?php
namespace api\modules\v1\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;
use api\lib\ModelErrors;
use api\lib\ApiRequest;
use api\lib\ApiController;
use common\models\task\Task;
use common\models\task\TaskSubmit;

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
     * @OA\Get(
     *      path="/v1/tasks",
     *      tags={"Task"},
     *      summary="作业列表",
     *      description="获取所有作业列表",
     *      @OA\Parameter(name="course_id", required=true, in="query",description="课程ID", @OA\Schema(type="integer")),
     *      @OA\Parameter(name="lesson_id", required=true, in="query",description="章节ID(必须与课程ID配合使用)", @OA\Schema(type="integer")),
     *      @OA\Response(response="default", description="返回结果")
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
     * @OA\Get(
     *      path="/v1/tasks/{id}",
     *      tags={"Task"},
     *      summary="作业详情",
     *      description="作业详情",
     *      @OA\Parameter(name="id", required=true, in="path",description="作业ID", @OA\Schema(type="string")),
     *      @OA\Response(response="default", description="返回结果")
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
     * 提交作业
     * @OA\Post(
     *      path="/v1/tasks/submits",
     *      tags={"Task"},
     *      summary="提交作业",
     *      description="提交作业",
     *      @OA\RequestBody(required=true, @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded", @OA\Schema(
     *              @OA\Property(description="作业ID", property="task_id", type="string"),
     *              @OA\Property(description="学生ID", property="user_id", type="string"),
     *              @OA\Property(description="提交内容", property="submit_content", type="string"),
     *              @OA\Property(description="提交文件", property="submit_file", type="string"),
     *              @OA\Property(description="提交音频", property="submit_audio", type="string"),
     *          )
     *      )),
     *      @OA\Response(response="default", description="返回结果"),
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
     * @OA\Get(
     *      path="/v1/tasks/submits",
     *      tags={"Task"},
     *      summary="提交详情",
     *      description="提交详情",
     *      @OA\Parameter(name="task_id", required=true, in="query",description="作业ID", @OA\Schema(type="string")),
     *      @OA\Parameter(name="user_id", required=true, in="query",description="学生ID", @OA\Schema(type="string")),
     *      @OA\Response(response="default", description="返回结果")
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
     * @OA\Get(
     *      path="/v1/tasks/user",
     *      tags={"Task"},
     *      summary="作业列表",
     *      description="作业列表(根据用户ID)",
     *      @OA\Parameter(name="user_id", required=true, in="query",description="作业ID", @OA\Schema(type="string")),
     *      @OA\Parameter(name="course_id", required=false, in="query",description="课程ID", @OA\Schema(type="string")),
     *      @OA\Parameter(name="lesson_id", required=false, in="query",description="章节ID", @OA\Schema(type="string")),
     *      @OA\Response(response="default", description="返回结果")
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
     * @OA\Get(
     *      path="/v1/tasks/user/{task_id}",
     *      tags={"Task"},
     *      summary="作业详情",
     *      description="作业详情(根据用户ID)",
     *      @OA\Parameter(name="task_id", required=true, in="path",description="作业ID", @OA\Schema(type="integer")),
     *      @OA\Parameter(name="user_id", required=true, in="query",description="学生ID", @OA\Schema(type="string")),
     *      @OA\Response(response="default", description="返回结果")
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