<?php
namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;
use api\lib\ApiRequest;
use api\lib\ApiController;
use api\lib\ModelErrors;
use common\models\user\UserFavorite;
use common\models\user\UserFavoriteSearch;

/**
 * @SWG\Tag(name="Favorite",description="收藏")
 */
class FavoritesController extends ApiController
{
    public $modelClass = 'common\models\user\UserFavorite';

    public function actions()
    {
        return [];
    }

    /**
     * 获取用户收藏
     * @SWG\GET(
     *     path="/v1/favorites",
     *     tags={"Favorite"},
     *     summary="用户收藏",
     *     description="获取用户收藏课程列表",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="user_id",type="integer", required=true, in="query",description="用户ID" ),
     *     @SWG\Response( response="return",description="收藏列表")
     * )
     */
    public function actionIndex(){
        //参数检测
        ApiRequest::checkGet(["user_id"]);

        //进行查询
        $searchModel = new UserFavoriteSearch();
        $dataProvider = $searchModel->search_api(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 0;
        $list = $dataProvider->getModels();

        //构建返回
        return $list;
    }

    /**
     * 添加用户收藏
     * @SWG\POST(
     *     path="/v1/favorites",
     *     tags={"Favorite"},
     *     summary="添加用户收藏",
     *     description="添加用户收藏",
     *     consumes={"application/x-www-form-urlencoded"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="user_id",type="string", required=true, in="formData",description="用户ID" ),
     *     @SWG\Parameter( name="course_id",type="string", required=true, in="formData",description="课程ID" ),
     *     @SWG\Response( response="return",description="用户信息")
     * )
     */
    public function actionCreate(){
        //参数检测
        ApiRequest::checkPost(["user_id","course_id"]);

        //保存并返回
        $model = new UserFavorite();
        if($model->load(Yii::$app->request->post(),"") && $model->save())
            return null;
        else
            throw new BadRequestHttpException(ModelErrors::getError($model));
    }

    /**
     * 添加用户收藏
     * @SWG\DELETE(
     *     path="/v1/favorites",
     *     tags={"Favorite"},
     *     summary="移除用户收藏",
     *     description="移除用户收藏",
     *     consumes={"application/x-www-form-urlencoded"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="user_id",type="string", required=true, in="formData",description="用户ID" ),
     *     @SWG\Parameter( name="course_id",type="string", required=true, in="formData",description="课程ID" ),
     *     @SWG\Response( response="return",description="用户信息")
     * )
     */
    public function actionDelete(){
        //参数检测
        ApiRequest::checkPost(["user_id","course_id"]);
        $user_id = Yii::$app->request->post("user_id");
        $course_id = Yii::$app->request->post("course_id");

        //查询模型
        $model = UserFavorite::findOne(["user_id"=>$user_id,"course_id"=>$course_id]);

        //进行删除
        if($model) $model->delete();
    }

    /**
     * 判断是否收藏
     * @SWG\GET(
     *     path="/v1/favorites/hash",
     *     tags={"Favorite"},
     *     summary="判断是否收藏",
     *     description="判断是否收藏",
     *     consumes={"application/x-www-form-urlencoded"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="user_id",type="string", required=true, in="query",description="用户ID" ),
     *     @SWG\Parameter( name="course_id",type="string", required=true, in="query",description="课程ID" ),
     *     @SWG\Response( response="return",description="用户信息")
     * )
     */
    public function actionHash(){
        //参数检测
        ApiRequest::checkGet(["user_id","course_id"]);
        $user_id = Yii::$app->request->get("user_id");
        $course_id = Yii::$app->request->get("course_id");

        //查询模型
        $model = UserFavorite::findOne(["user_id"=>$user_id,"course_id"=>$course_id]);

        //返回
        if($model)
            return true;
        else
            return false;
    }
}