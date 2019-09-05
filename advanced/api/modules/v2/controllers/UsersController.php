<?php
namespace api\modules\v2\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use api\lib\ApiController;
use api\lib\ApiRequest;
use api\lib\ModelErrors;
use common\models\user\User;
use common\models\user\SignupForm;
use common\models\user\UserCourse;
use common\models\user\UserSearch;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

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
    public $authActions = ["check-login"];

    public function actions()
    {
        return [];
    }

    /**
     * 用户列表
     * @OA\Get(
     *      path="/v2/users",
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
     * 用户注册
     * @OA\Post(
     *      path="/v2/users",
     *      tags={"User"},
     *      summary="用户注册",
     *      description="创建新用户",
     *      @OA\RequestBody(required=true, @OA\MediaType(
     *          mediaType="application/json", @OA\Schema(
     *              @OA\Property(description="邮箱", property="email", type="string"),
     *              @OA\Property(description="密码", property="password", type="string"),
     *              @OA\Property(description="验证码", property="captcha", type="string"),
     *              @OA\Property(description="昵称", property="nickname", type="string"),
     *              @OA\Property(description="性别(1:男，0:女)", property="sex", type="string"),
     *              @OA\Property(description="头像(URL)", property="avatar", type="string"),
     *              @OA\Property(description="电话", property="phone", type="string"),
     *              @OA\Property(description="国家", property="country", type="string"),
     *              @OA\Property(description="城市", property="city", type="string"),
     *              @OA\Property(description="地址1", property="adderss_1", type="string"),
     *              @OA\Property(description="地址2", property="adderss_2", type="string"),
     *              example={"email":"user@yii.com","password":"123456","captcha":"123123","nickname":"yii123123","sex":1,"avatar":"http://pdt1od3ni.bkt.clouddn.com//5bb851c360398.jpg","phone":"123123","country":"sad","city":"dsa","adderss_1":"艾欧尼亚","adderss_2":""}
     *          )
     *      )),
     *      @OA\Response(response="default", description="返回结果"),
     * )
     */
    public function actionCreate(){
        //参数检测
        $params = ApiRequest::getJsonParams(["email","captcha","nickname","password"]);

        //开启Session
        $session = Yii::$app->session;
        if(!$session->isActive)
            $session->open();

        //验证邮箱
        $captcha = $session->get("captcha_$params->email");
        if($captcha != $params->captcha)
            throw new HttpException(401, 'verification captcha incorrect');

        //创建用户
        $model = new SignupForm();
        if($model->load(ArrayHelper::toArray($params),"") && $model->save()){
            return $model;
        }
        else{
            throw new BadRequestHttpException(ModelErrors::getError($model));
        }
    }

    /**
     * 用户信息
     * @OA\Get(
     *      path="/v2/users/{id}",
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
     * 修改信息
     * @OA\Put(
     *      path="/v2/users/{id}",
     *      tags={"User"},
     *      summary="修改信息",
     *      description="修改用户个人资料信息",
     *      @OA\Parameter(name="id", required=true, in="path",description="用户ID", @OA\Schema(type="integer")),
     *      @OA\Parameter(name="user_id", required=true, in="header",description="用户ID", @OA\Schema(type="integer",default="12")),
     *      @OA\Parameter(name="user_token", required=true, in="header",description="用户TOKEN", @OA\Schema(type="string",default="5d56a3471832b")),
     *      @OA\RequestBody(required=true, @OA\MediaType(
     *          mediaType="application/json", @OA\Schema(
     *              @OA\Property(description="昵称", property="nickname", type="string"),
     *              @OA\Property(description="性别(1:男，0:女)", property="sex", type="string"),
     *              @OA\Property(description="头像(URL)", property="avatar", type="string"),
     *              @OA\Property(description="电话", property="phone", type="string"),
     *              @OA\Property(description="国家", property="country", type="string"),
     *              @OA\Property(description="城市", property="city", type="string"),
     *              @OA\Property(description="地址1", property="adderss_1", type="string"),
     *              @OA\Property(description="地址2", property="adderss_2", type="string"),
     *              example={"nickname":"yii123123","sex":1,"avatar":"http://pdt1od3ni.bkt.clouddn.com//5bb851c360398.jpg","phone":"123123","country":"sad","city":"dsa","adderss_1":"艾欧尼亚","adderss_2":""}
     *          )
     *      )),
     *      @OA\Response(response="default", description="返回结果"),
     * )
     */
    public function actionUpdate($id){
        //获取参数，并过滤敏感属性
        $params = ApiRequest::getJsonParams([]);
        if(isset($params->email)) unset($params->email);
        if(isset($params->password_hash)) unset($params->password_hash);

        //获取用户
        $model = User::findOne($id);
        if(!$model)
            throw new BadRequestHttpException("not fount user.");

        //修改用户信息并保存
        if($model->load(ArrayHelper::toArray($params),"") && $model->save()){
            return $model;
        }
        else{
            throw new BadRequestHttpException(ModelErrors::getError($model));
        }
    }

    /**
     * 修改密码
     * @OA\Put(
     *      path="/v2/users/{id}/password",
     *      tags={"User"},
     *      summary="修改密码",
     *      description="修改密码",
     *      @OA\Parameter(name="id", required=true, in="path",description="用户ID", @OA\Schema(type="integer")),
     *      @OA\Parameter(name="user_id", required=true, in="header",description="用户ID", @OA\Schema(type="integer",default="12")),
     *      @OA\Parameter(name="user_token", required=true, in="header",description="用户TOKEN", @OA\Schema(type="string",default="5d56a3471832b")),
     *      @OA\RequestBody(required=true, @OA\MediaType(
     *          mediaType="application/json", @OA\Schema(
     *              @OA\Property(description="邮箱", property="email", type="string"),
     *              @OA\Property(description="旧密码", property="password", type="string"),
     *              @OA\Property(description="新密码", property="password_new", type="string"),
     *              @OA\Property(description="再次输入密码", property="password_again", type="string"),
     *              example={"email":"user@yii.com","password":"123456","password_new":"654321","password_again":"654321"}
     *          )
     *      )),
     *      @OA\Response(response="default", description="返回结果"),
     * )
     */
    public function actionUpdatePassword($id){
        //参数检测
        $params = ApiRequest::getJsonParams(["email","password","password_new","password_again"]);
        $email = $params->email;
        $password = $params->password;
        $password_new = $params->password_new;
        $password_again = $params->password_again;

        //密码认证
        $model = User::findOne(["id"=>$id,"email"=>$email]);
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
     * 用户登录
     * @OA\Post(
     *      path="/v2/users/login",
     *      tags={"User"},
     *      summary="用户登录",
     *      description="用户登录",
     *      @OA\RequestBody(required=true, @OA\MediaType(
     *          mediaType="application/json", @OA\Schema(
     *              @OA\Property(description="邮箱", property="email", type="string"),
     *              @OA\Property(description="密码", property="password", type="string"),
     *              example={"email":"evon1991@163.com","password":"123456"}
     *          )
     *      )),
     *      @OA\Response(response="default", description="返回结果"),
     * )
     */
    public function actionLogin(){
        //参数检测
        $params = ApiRequest::getJsonParams(["email","password"]);

        //获取用户
        $model = User::findOne(["email"=>$params->email]);

        //判断密码并返回
        if ($model && Yii::$app->security->validatePassword($params->password, $model->password_hash)) {
            $model->refreshLoginToken();//刷新登录Token
            return $model;
        }
        else{
            throw new BadRequestHttpException('username or password is wrong');
        }
    }

    /**
     * 登录检测
     * @OA\Post(
     *      path="/v2/users/check-login",
     *      tags={"User"},
     *      summary="登录检测",
     *      description="通过token检测,防止用户重复登录",
     *      @OA\Parameter(name="user_id", required=true, in="header",description="用户ID", @OA\Schema(type="integer",default="12")),
     *      @OA\Parameter(name="user_token", required=true, in="header",description="用户TOKEN", @OA\Schema(type="string",default="5d56a3471832b")),
     *      @OA\Response(response="default", description="返回结果"),
     * )
     */
    public function actionCheckLogin(){
        return "SUCCESS";
    }

    /**
     * 发送认证码
     * @OA\POST(
     *      path="/v2/users/captcha/email",
     *      tags={"User"},
     *      summary="发送认证码",
     *      description="发送认证码到用户邮箱",
     *      @OA\RequestBody(required=true, @OA\MediaType(
     *          mediaType="application/json", @OA\Schema(
     *              @OA\Property(property="email", type="string", description="用户邮箱"),
     *              example={"email": "evon1991@163.com"}
     *          )
     *      )),
     *      @OA\Response(response="default", description="返回结果"),
     * )
     */
    public function actionCaptchaEmail(){
        //获取参数
        $params = ApiRequest::getJsonParams(["email"]);

        //开启Session
        $session = Yii::$app->session;
        if(!$session->isActive)
            $session->open();

        //生成验证码
        $captcha = rand(100000,999999);

        //保存验证码到Session
        $session->set("captcha_$params->email", $captcha);

        //发送邮件
        $result = Yii::$app->mailer->compose('template/captcha.php', ['code'=>$captcha])
            ->setFrom(Yii::$app->params["supportEmail"])
            ->setTo([$params->email])
            ->setSubject('i-Link 用户注册')
            ->send();

        //返回结果
        return $result;
    }

    /**
     * 读取认证码
     * @OA\POST(
     *      path="/v2/users/captcha/read",
     *      tags={"User"},
     *      summary="读取认证码(调试用)",
     *      description="读取认证码(调试用)",
     *      @OA\RequestBody(required=true, @OA\MediaType(
     *          mediaType="application/json", @OA\Schema(
     *              @OA\Property(property="email", type="string", description="用户邮箱"),
     *              example={"email": "evon1991@163.com"}
     *          )
     *      )),
     *      @OA\Response(response="default", description="返回结果"),
     * )
     */
    public function actionCaptchaRead(){
        //获取参数
        $params = ApiRequest::getJsonParams(["email"]);

        //开启Session
        $session = Yii::$app->session;
        if(!$session->isActive)
            $session->open();

        //读取Session
        $captcha = $session->get("captcha_$params->email");

        //返回结果
        return $captcha;
    }
}