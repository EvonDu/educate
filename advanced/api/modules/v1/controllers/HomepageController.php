<?php
namespace api\modules\v1\controllers;

use yii\helpers\ArrayHelper;
use api\lib\ApiController;
use common\models\homepage\Homepage;
use common\models\homepage\HomepageItems;

/**
 * @OA\Tag(name="Homepage",description="主页")
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
     * @OA\Get(
     *      path="/v1/homepage",
     *      tags={"Homepage"},
     *      summary="首页信息",
     *      description="获取首页信息",
     *      @OA\Response(response="default", description="返回结果")
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