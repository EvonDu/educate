<?php
namespace api\modules\v1\controllers;

use api\lib\ApiRequest;
use common\models\course\CourseTypeSearch;
use common\models\user\UserFavorite;
use common\models\user\UserFavoriteSearch;
use common\models\user\UserSearch;
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
 *     definition="CourseType",
 *     @SWG\Property(property="id",description="ID",type="integer"),
 *     @SWG\Property(property="name",description="课程类型",type="string"),
 *     @SWG\Property(property="created_at",description="创建时间（时间戳）",type="integer"),
 *     @SWG\Property(property="updated_at",description="更新时间（时间戳）",type="integer"),
 * )
 */

class TypesController extends ActiveController
{
    public $modelClass = 'common\models\course\CourseType';

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
        return [];
    }

    /**
     * 课程类型
     * @SWG\GET(
     *     path="/v1/types",
     *     tags={"Course"},
     *     summary="课程类型",
     *     description="获取所有课程类型",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="page",type="integer", required=false, in="query",description="分页" ),
     *     @SWG\Parameter( name="pageSize",type="integer", required=false, in="query",description="查询数量" ),
     *     @SWG\Response( response="return",description="课程类型列表")
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