<?php
namespace api\modules\v1\controllers;

use api\lib\ApiController;
use api\lib\ApiRequest;
use common\models\instructor\Instructor;
use common\models\instructor\InstructorSearch;
use Yii;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;
use api\lib\ModelErrors;
use common\models\user\User;
use common\models\user\SignupForm;

/**
 * @SWG\Definition(
 *     definition="Instructor",
 *     @SWG\Property(property="id",description="ID",type="string"),
 *     @SWG\Property(property="name",description="导师名",type="integer"),
 *     @SWG\Property(property="avatar",description="头像",type="string"),
 *     @SWG\Property(property="title",description="头衔",type="string"),
 *     @SWG\Property(property="tags",description="标签",type="string"),
 *     @SWG\Property(property="abstract",description="简介",type="string"),
 *     @SWG\Property(property="created_at",description="创建时间（时间戳）",type="integer"),
 *     @SWG\Property(property="updated_at",description="更新时间（时间戳）",type="integer"),
 * )
 */

/**
 * @SWG\Tag(name="Instructor",description="导师")
 */
class InstructorsController extends ApiController
{
    public $modelClass = 'common\models\instructor\Instructor';

    public function actions()
    {
        return [];
    }

    /**
     * 教师列表
     * @SWG\GET(
     *     path="/v1/instructors",
     *     tags={"Instructor"},
     *     summary="教师列表",
     *     description="获取教师列表（教师数据中的字段均可用作筛选和排序）",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="page",type="integer", required=false, in="path",description="分页" ),
     *     @SWG\Parameter( name="pageSize",type="integer", required=false, in="query",description="查询数量" ),
     *     @SWG\Parameter( name="tags",type="integer", required=false, in="query",description="标签" ),
     *     @SWG\Response( response="return",description="教师列表")
     * )
     */
    public function actionIndex(){
        //查询
        $searchModel = new InstructorSearch();
        $dataProvider = $searchModel->search_api(Yii::$app->request->queryParams);

        //设置分页
        $pagination = ApiRequest::injectionPage($dataProvider);

        //构建返回
        $result = array_merge($pagination,[
            "items" => $dataProvider->getModels()
        ]);
        return $result;
    }

    /**
     * 教师详情
     * @SWG\GET(
     *     path="/v1/instructors/{id}",
     *     tags={"Instructor"},
     *     summary="教师详情",
     *     description="根据ID获取教师信息",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="id",type="integer", required=true, in="path",description="ID" ),
     *     @SWG\Response( response="return",description="教师详情")
     * )
     */
    public function actionView($id){
        $model = Instructor::findOne($id);
        if(!$model)
            throw new NotFoundHttpException("Not found:$id");

        return $model;
    }
}