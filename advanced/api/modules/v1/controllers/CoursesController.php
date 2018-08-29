<?php
namespace api\modules\v1\controllers;

use common\models\course\CourseSearch;
use common\models\media\Pronunciation;
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
        return $parent;
    }

    /**
     * 课程列表
     * @SWG\GET(
     *     path="/v1/courses",
     *     tags={"Media"},
     *     summary="课程列表",
     *     description="获取所有课程列表(所有字段均可作为参数作模糊查询)",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="page",type="integer", required=false, in="path",description="页码" ),
     *     @SWG\Response( response="return",description="课程列表")
     * )
     */
    public function actionIndex(){
        $searchModel = new CourseSearch();
        $dataProvider = $searchModel->search_api(Yii::$app->request->queryParams);

        $models = $dataProvider->getModels();
        $result = [];
        foreach ($models as $model){
            $item = [
                "num" => $model->num,
                "name" => $model->name,
                "image" => $model->image,
                "abstract" => $model->abstract,
            ];
            $result[] = $item;
        }

        return $result;
    }
}