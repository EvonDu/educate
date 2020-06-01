<?php
namespace api\modules\v1\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use api\lib\ApiRequest;
use api\lib\ApiController;
use common\models\instructor\Instructor;
use common\models\instructor\InstructorSearch;

/**
 * @OA\Tag(name="Instructor",description="导师")
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
     * @OA\Get(
     *      path="/v1/instructors",
     *      tags={"Instructor"},
     *      summary="教师列表",
     *      description="获取教师列表（教师数据中的字段均可用作筛选和排序）",
     *      @OA\Parameter(name="page", required=false, in="query",description="分页", @OA\Schema(type="integer")),
     *      @OA\Parameter(name="pageSize", required=false, in="query",description="查询数量", @OA\Schema(type="integer")),
     *      @OA\Parameter(name="tags", required=false, in="query",description="标签", @OA\Schema(type="integer")),
     *      @OA\Response(response="default", description="返回结果")
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
     * @OA\Get(
     *      path="/v1/instructors/{id}",
     *      tags={"Instructor"},
     *      summary="教师详情",
     *      description="根据ID获取教师信息",
     *      @OA\Parameter(name="id", required=true, in="path",description="ID", @OA\Schema(type="integer")),
     *      @OA\Response(response="default", description="返回结果")
     * )
     */
    public function actionView($id){
        $model = Instructor::findOne($id);
        if(!$model)
            throw new NotFoundHttpException("Not found:$id");

        return $model;
    }
}