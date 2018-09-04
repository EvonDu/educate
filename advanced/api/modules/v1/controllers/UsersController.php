<?php
namespace api\modules\v1\controllers;

use api\lib\ApiRequest;
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
 *     definition="User",
 *     @SWG\Property(property="id",description="ID",type="integer"),
 *     @SWG\Property(property="email",description="邮箱",type="string"),
 *     @SWG\Property(property="firstname",description="名称",type="string"),
 *     @SWG\Property(property="lastname",description="姓氏",type="string"),
 *     @SWG\Property(property="sex",description="性别",type="integer"),
 *     @SWG\Property(property="avatar",description="头像",type="string"),
 *     @SWG\Property(property="phone",description="电话",type="string"),
 *     @SWG\Property(property="country",description="国家",type="string"),
 *     @SWG\Property(property="city",description="城市",type="string"),
 *     @SWG\Property(property="adderss_1",description="地址1",type="string"),
 *     @SWG\Property(property="adderss_2",description="地址2",type="string"),
 *     @SWG\Property(property="created_at",description="创建时间（时间戳）",type="integer"),
 *     @SWG\Property(property="updated_at",description="更新时间（时间戳）",type="integer"),
 * )
 */

/**
 * @SWG\Tag(name="User",description="用户")
 */
class UsersController extends ActiveController
{
    public $modelClass = 'common\models\user\User';

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
     * 用户列表
     * @SWG\GET(
     *     path="/v1/users",
     *     tags={"User"},
     *     summary="用户列表",
     *     description="获取用户列表表（数据中的字段均可用作筛选和排序）",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="page",type="integer", required=false, in="query",description="分页" ),
     *     @SWG\Parameter( name="pageSize",type="integer", required=false, in="query",description="查询数量" ),
     *     @SWG\Parameter( name="sex",type="integer", required=false, in="query",description="性别" ),
     *     @SWG\Parameter( name="country",type="string", required=false, in="query",description="国家" ),
     *     @SWG\Parameter( name="city",type="string", required=false, in="query",description="城市" ),
     *     @SWG\Response( response="return",description="用户列表")
     * )
     */
    public function actionIndex(){
        //构建数据提供者
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //设置分页
        $pagination = ApiRequest::injectionPage($dataProvider);

        //构建返回
        $result = array_merge($pagination,[
            "items" => $dataProvider->getModels()
        ]);
        return $result;
    }

    /**
     * 用户信息
     * @SWG\GET(
     *     path="/v1/users/{id}",
     *     tags={"User"},
     *     summary="用户列表",
     *     description="获取用户列表表（数据中的字段均可用作筛选和排序）",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="id",type="integer", required=true, in="path",description="用户ID" ),
     *     @SWG\Response( response="return",description="用户列表")
     * )
     */
    public function actionView($id){
        $model = User::findOne($id);
        if($model)
            return $model;
        else
            throw new BadRequestHttpException("not fount user.");
    }

    /**
     * 用户注册
     * @SWG\POST(
     *     path="/v1/users",
     *     tags={"User"},
     *     summary="用户注册",
     *     description="创建新用户",
     *     consumes={"application/x-www-form-urlencoded"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="email",type="string", required=true, in="formData",description="注册邮箱" ),
     *     @SWG\Parameter( name="password",type="string", required=true, in="formData",description="密码" ),
     *     @SWG\Parameter( name="firstname",type="string", required=true, in="formData",description="名称" ),
     *     @SWG\Parameter( name="lastname",type="string", required=true, in="formData",description="姓氏" ),
     *     @SWG\Parameter( name="sex",type="integer", required=false, in="formData",description="性别(1:男，0:女)" ),
     *     @SWG\Parameter( name="avatar",type="string", required=false, in="formData",description="头像(URL)" ),
     *     @SWG\Parameter( name="phone",type="string", required=false, in="formData",description="电话" ),
     *     @SWG\Parameter( name="country",type="string", required=false, in="formData",description="国家" ),
     *     @SWG\Parameter( name="city",type="string", required=false, in="formData",description="城市" ),
     *     @SWG\Parameter( name="adderss_1",type="string", required=false, in="formData",description="地址1" ),
     *     @SWG\Parameter( name="adderss_2",type="string", required=false, in="formData",description="地址2" ),
     *     @SWG\Response( response="return",description="用户信息")
     * )
     */
    public function actionCreate(){
        //参数检测
        ApiRequest::checkPost(["email","firstname","lastname"]);

        //创建用户
        $model = new SignupForm();
        if($model->load(Yii::$app->request->post(),"") && $model->save()){
            return $model;
        }
        else{
            throw new BadRequestHttpException(ModelErrors::getError($model));
        }
    }

    /**
     * 修改用户信息
     * @SWG\PUT(
     *     path="/v1/users/{id}",
     *     tags={"User"},
     *     summary="修改用户信息",
     *     description="修改用户信息",
     *     consumes={"application/x-www-form-urlencoded"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="id",type="integer", required=true, in="path",description="用户ID" ),
     *     @SWG\Parameter( name="firstname",type="string", required=true, in="formData",description="名称" ),
     *     @SWG\Parameter( name="lastname",type="string", required=true, in="formData",description="姓氏" ),
     *     @SWG\Parameter( name="sex",type="integer", required=false, in="formData",description="性别(1:男，0:女)" ),
     *     @SWG\Parameter( name="avatar",type="string", required=false, in="formData",description="头像(URL)" ),
     *     @SWG\Parameter( name="phone",type="string", required=false, in="formData",description="电话" ),
     *     @SWG\Parameter( name="country",type="string", required=false, in="formData",description="国家" ),
     *     @SWG\Parameter( name="city",type="string", required=false, in="formData",description="城市" ),
     *     @SWG\Parameter( name="adderss_1",type="string", required=false, in="formData",description="地址1" ),
     *     @SWG\Parameter( name="adderss_2",type="string", required=false, in="formData",description="地址2" ),
     *     @SWG\Response( response="return",description="用户信息")
     * )
     */
    public function actionUpdate($id){
        //获取用户
        $model = User::findOne($id);
        if(!$model)
            throw new BadRequestHttpException("not fount user.");

        //过滤敏感属性
        $params = Yii::$app->request->post();
        if(isset($params["email"])) unset($params["email"]);
        if(isset($params["password_hash"])) unset($params["password_hash"]);

        //修改用户信息并保存
        if($model->load(Yii::$app->request->post(),"") && $model->save()){
            return $model;
        }
        else{
            throw new BadRequestHttpException(ModelErrors::getError($model));
        }
    }

    /**
     * 获取用户收藏
     * @SWG\GET(
     *     path="/v1/users/favorites",
     *     tags={"User"},
     *     summary="用户收藏",
     *     description="获取用户收藏课程列表",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="user_id",type="integer", required=true, in="query",description="用户ID" ),
     *     @SWG\Response( response="return",description="收藏列表")
     * )
     */
    public function actionFavorites(){
        //参数检测
        ApiRequest::checkGet(["user_id"]);

        //进行查询
        $searchModel = new UserFavoriteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //设置分页
        $pagination = ApiRequest::injectionPage($dataProvider);

        //构建返回
        $result = array_merge($pagination,[
            "items" => $dataProvider->getModels()
        ]);
        return $result;
    }

    /**
     * 添加用户收藏
     * @SWG\POST(
     *     path="/v1/users/favorites",
     *     tags={"User"},
     *     summary="添加用户收藏",
     *     description="添加用户收藏",
     *     consumes={"application/x-www-form-urlencoded"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="user_id",type="string", required=true, in="formData",description="用户ID" ),
     *     @SWG\Parameter( name="course_id",type="string", required=true, in="formData",description="课程ID" ),
     *     @SWG\Response( response="return",description="用户信息")
     * )
     */
    public function actionFavoritesCreate(){
        //参数检测
        ApiRequest::checkPost(["user_id","course_id"]);

        //保存并返回
        $model = new UserFavorite();
        if($model->load(Yii::$app->request->post(),"") && $model->save()){
            return null;
        }
        else{
            throw new BadRequestHttpException(ModelErrors::getError($model));
        }
    }

    /**
     * 添加用户收藏
     * @SWG\DELETE(
     *     path="/v1/users/favorites",
     *     tags={"User"},
     *     summary="移除用户收藏",
     *     description="移除用户收藏",
     *     consumes={"application/x-www-form-urlencoded"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="user_id",type="string", required=true, in="formData",description="用户ID" ),
     *     @SWG\Parameter( name="course_id",type="string", required=true, in="formData",description="课程ID" ),
     *     @SWG\Response( response="return",description="用户信息")
     * )
     */
    public function actionFavoritesDelete(){
        //参数检测
        ApiRequest::checkPost(["user_id","course_id"]);
        $user_id = Yii::$app->request->post("user_id");
        $course_id = Yii::$app->request->post("course_id");

        //查询模型
        $model = UserFavorite::findOne(["user_id"=>$user_id,"course_id"=>$course_id]);

        //进行删除
        if($model) $model->delete();
    }
}