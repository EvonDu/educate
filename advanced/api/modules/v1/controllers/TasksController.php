<?php
namespace api\modules\v1\controllers;

use common\models\task\Task;
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
}