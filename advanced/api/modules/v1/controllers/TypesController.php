<?php
namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;
use api\lib\ApiController;
use api\lib\ApiRequest;
use api\lib\ModelErrors;
use common\models\course\CourseTypeSearch;

class TypesController extends ApiController
{
    public $modelClass = 'common\models\course\CourseType';

    public function actions()
    {
        return [];
    }

    /**
     * 课程类型
     * @OA\Get(
     *      path="/v1/types",
     *      tags={"Course"},
     *      summary="课程类型",
     *      description="获取所有课程类型",
     *      @OA\Parameter(name="page", required=false, in="query",description="分页", @OA\Schema(type="integer")),
     *      @OA\Parameter(name="pageSize", required=false, in="query",description="查询数量", @OA\Schema(type="integer")),
     *      @OA\Response(response="default", description="返回结果")
     * )
     */
    public function actionIndex(){
        //查询类
        $searchModel = new CourseTypeSearch();
        $dataProvider = $searchModel->search_api(Yii::$app->request->queryParams);

        //设置分页
        $pagination = ApiRequest::injectionPage($dataProvider);

        //构建返回
        $result = array_merge($pagination,[
            "items" => $dataProvider->getModels()
        ]);
        return $result;
    }
}