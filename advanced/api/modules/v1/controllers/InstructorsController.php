<?php
namespace api\modules\v1\controllers;

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
 * @SWG\Tag(name="Instructor",description="教师")
 */
class InstructorsController extends ActiveController
{
    public $modelClass = 'common\models\instructor\Instructor';

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
     * 获取读音
     * @SWG\GET(
     *     path="/v1/instructors",
     *     tags={"Instructor"},
     *     summary="教师列表",
     *     description="获取教师列表（教师数据中的字段均可用作筛选和排序）",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="page",type="integer", required=false, in="path",description="分页" ),
     *     @SWG\Response( response="return",description="教师列表")
     * )
     */
    public function actionIndex(){
        //查询
        $searchModel = new InstructorSearch();
        $dataProvider = $searchModel->search_api(Yii::$app->request->queryParams);
        $items = $dataProvider->getModels();

        //分页数据
        $totalCount = $dataProvider->totalCount;
        $page = (int)Yii::$app->request->get("page",1);
        $pageSize = $dataProvider->pagination->pageSize;
        $pageCount = $dataProvider->pagination->pageCount;

        //构建返回
        $result = [
            "page" => $page,
            "pageCount" => $pageCount,
            "pageSize" => $pageSize,
            "totalCount" => $totalCount,
            "items" => $items,
        ];
        return $result;
    }

    /**
     * 获取读音
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