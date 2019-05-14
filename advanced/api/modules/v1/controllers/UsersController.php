<?php
namespace api\modules\v1\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use api\lib\ApiController;
use api\lib\ApiRequest;
use api\lib\ModelErrors;
use common\models\user\User;
use common\models\user\SignupForm;
use common\models\user\UserCourse;
use common\models\user\UserSearch;

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
class UsersController extends ApiController
{
    public $modelClass = 'common\models\user\User';

    public function actions()
    {
        return [];
    }

    /**
     * 用户列表
     * @OA\Get(
     *      path="/v1/users",
     *      tags={"User"},
     *      summary="用户列表",
     *      description="获取用户列表表（数据中的字段均可用作筛选和排序）",
     *      @OA\Parameter(name="page", required=false, in="query",description="分页", @OA\Schema(type="integer")),
     *      @OA\Parameter(name="pageSize", required=false, in="query",description="查询数量", @OA\Schema(type="integer")),
     *      @OA\Parameter(name="sex", required=false, in="query",description="性别", @OA\Schema(type="integer")),
     *      @OA\Parameter(name="country", required=false, in="query",description="国家", @OA\Schema(type="string")),
     *      @OA\Parameter(name="city", required=false, in="query",description="城市", @OA\Schema(type="string")),
     *      @OA\Response(response="default", description="返回结果")
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
     * @OA\Get(
     *      path="/v1/users/{id}",
     *      tags={"User"},
     *      summary="用户信息",
     *      description="用户信息",
     *      @OA\Parameter(name="id", required=false, in="path",description="用户ID", @OA\Schema(type="integer")),
     *      @OA\Response(response="default", description="返回结果")
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
     * @OA\Post(
     *      path="/v1/users",
     *      tags={"User"},
     *      summary="用户注册",
     *      description="创建新用户",
     *      @OA\RequestBody(required=true, @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded", @OA\Schema(
     *              @OA\Property(description="邮箱", property="email", type="string"),
     *              @OA\Property(description="昵称", property="nickname", type="string"),
     *              @OA\Property(description="密码", property="password", type="string"),
     *              @OA\Property(description="性别(1:男，0:女)", property="sex", type="string"),
     *              @OA\Property(description="头像(URL)", property="avatar", type="string"),
     *              @OA\Property(description="电话", property="phone", type="string"),
     *              @OA\Property(description="国家", property="country", type="string"),
     *              @OA\Property(description="城市", property="city", type="string"),
     *              @OA\Property(description="地址1", property="adderss_1", type="string"),
     *              @OA\Property(description="地址2", property="adderss_2", type="string"),
     *          )
     *      )),
     *      @OA\Response(response="default", description="返回结果"),
     * )
     */
    public function actionCreate(){
        //参数检测
        ApiRequest::checkPost(["email","nickname"]);

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
     * 修改信息
     * @OA\Put(
     *      path="/v1/user/{id}",
     *      tags={"User"},
     *      summary="修改信息",
     *      description="修改用户个人资料信息",
     *      @OA\Parameter(name="id", required=true, in="path",description="用户ID", @OA\Schema(type="integer")),
     *      @OA\RequestBody(required=true, @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded", @OA\Schema(
     *              @OA\Property(description="昵称", property="nickname", type="string"),
     *              @OA\Property(description="性别(1:男，0:女)", property="sex", type="integer"),
     *              @OA\Property(description="头像(URL)", property="avatar", type="string"),
     *              @OA\Property(description="电话", property="phone", type="string"),
     *              @OA\Property(description="国家", property="country", type="string"),
     *              @OA\Property(description="城市", property="city", type="string"),
     *              @OA\Property(description="地址1", property="adderss_1", type="string"),
     *              @OA\Property(description="地址2", property="adderss_2", type="string"),
     *          )
     *      )),
     *      @OA\Response(response="default", description="返回结果"),
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
     * 用户登录
     * @OA\Post(
     *      path="/v1/users/login",
     *      tags={"User"},
     *      summary="用户登录",
     *      description="用户登录",
     *      @OA\RequestBody(required=true, @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded", @OA\Schema(
     *              @OA\Property(description="邮箱", property="email", type="string"),
     *              @OA\Property(description="密码", property="password", type="string"),
     *          )
     *      )),
     *      @OA\Response(response="default", description="返回结果"),
     * )
     */
    public function actionLogin(){
        //参数检测
        ApiRequest::checkPost(["email","password"]);
        $email = Yii::$app->request->post("email",null);
        $password = Yii::$app->request->post("password",null);

        //获取用户
        $model = User::findOne(["email"=>$email]);

        //判断密码并返回
        if ($model && Yii::$app->security->validatePassword($password, $model->password_hash)) {
            return $model;
        }
        else{
            throw new BadRequestHttpException('username or password is wrong');
        }
    }

    /**
     * 修改密码
     * @OA\Put(
     *      path="/v1/users/modify-password",
     *      tags={"User"},
     *      summary="修改密码",
     *      description="修改密码",
     *      @OA\RequestBody(required=true, @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded", @OA\Schema(
     *              @OA\Property(description="邮箱", property="email", type="string"),
     *              @OA\Property(description="旧密码", property="password", type="integer"),
     *              @OA\Property(description="新密码", property="password_new", type="string"),
     *              @OA\Property(description="再次输入密码", property="password_again", type="string"),
     *          )
     *      )),
     *      @OA\Response(response="default", description="返回结果"),
     * )
     */
    public function actionModifyPassword(){
        //参数检测
        ApiRequest::checkPost(["email","password","password_new","password_again"]);
        $email = Yii::$app->request->post("email",null);
        $password = Yii::$app->request->post("password",null);
        $password_new = Yii::$app->request->post("password_new",null);
        $password_again = Yii::$app->request->post("password_again",null);

        //密码认证
        $model = User::findOne(["email"=>$email]);
        if (!($model && Yii::$app->security->validatePassword($password, $model->password_hash))) {
            throw new BadRequestHttpException('username or password is wrong');
        }

        //验证两次输出
        if($password_new != $password_again)
            throw new BadRequestHttpException('two input password must be consistent');

        //设置新密码
        $model->password_hash = Yii::$app->security->generatePasswordHash($password_new);

        //保存修改
        if(!$model->save()){
            throw new BadRequestHttpException(ModelErrors::getError($model));
        }
    }

    /**
     * 用户课程
     * @OA\Get(
     *      path="/v1/users/courses",
     *      tags={"User"},
     *      summary="用户课程",
     *      description="获取用户课程列表(拥有的课程列表)",
     *      @OA\Parameter(name="user_id", required=false, in="query",description="用户ID", @OA\Schema(type="integer")),
     *      @OA\Response(response="default", description="返回结果")
     * )
     */
    public function actionCourses(){
        //参数检测
        ApiRequest::checkGet(["user_id"]);
        $user_id = Yii::$app->request->get("user_id");

        //进行查询
        $list = UserCourse::getHaveCourse($user_id);

        //构建返回
        return $list;
    }
}