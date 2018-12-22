<?php
namespace api\modules\v1\controllers;

use common\models\homepage\Homepage;
use common\models\homepage\HomepageItems;
use Yii;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;
use api\lib\ApiController;
use api\lib\ModelErrors;
use common\models\page\Page;

/**
 * @SWG\Tag(name="Homepage",description="主页")
 */
class HomepageController extends ApiController
{
    public $modelClass = 'common\models\homepage\Homepage';

    public function actions()
    {
        return [];
    }

    /**
     * 首页信息
     * @SWG\GET(
     *     path="/v1/homepage",
     *     tags={"Homepage"},
     *     summary="首页信息",
     *     description="获取首页信息",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response( response="return",description="首页信息列表")
     * )
     */
    public function actionIndex(){
        //获取数据
        $main = Homepage::getModel();
        $items = HomepageItems::getAll();

        //返回
        $result = ArrayHelper::toArray($main);
        $result["items"] = $items;
        return $result;
    }
}