<?php
namespace api\modules\v1\controllers;

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
 *     @SWG\Property(property="id",description="ID",type="string"),
 *     @SWG\Property(property="username",description="用户名",type="string"),
 *     @SWG\Property(property="auth_key",description="授权秘钥",type="string"),
 *     @SWG\Property(property="email",description="邮箱",type="string"),
 *     @SWG\Property(property="created_at",description="创建时间（时间戳）",type="integer"),
 *     @SWG\Property(property="updated_at",description="更新时间（时间戳）",type="integer"),
 * )
 */

/**
 * @SWG\Definition(
 *     definition="UserInfo",
 *     @SWG\Property(property="id",description="ID",type="string"),
 *     @SWG\Property(property="user_id",description="用户ID",type="string"),
 *     @SWG\Property(property="nickname",description="用户昵称",type="string"),
 *     @SWG\Property(property="picture",description="用户头像",type="string"),
 *     @SWG\Property(property="phone",description="用户电话",type="string"),
 * )
 */

/**
 * @SWG\Tag(name="User",description="用户模块")
 */
class UserController extends ActiveController
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

    /**
     * 用户列表
     * @SWG\GET(
     *     path="/v1/user",
     *     tags={"User"},
     *     summary="用户列表",
     *     description="",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response(
     *          response="list",
     *          description="用户列表",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/User")
     *          )
     *     )
     * )
     */

    /**
     * 修改状态
     * @SWG\PUT(
     *     path="/v1/user/{id}",
     *     tags={"User"},
     *     summary="修改状态",
     *     description="修改账号信息，当前只能修改用户状态",
     *     consumes={"application/x-www-form-urlencoded"},
     *     produces={"application/json"},
     *     @SWG\Parameter(name="id",type="integer", required=true, in="path",description="用户ID"),
     *     @SWG\Parameter(name="status",type="integer", required=true, in="formData",description="用户状态",enum={10, 0}),
     *     @SWG\Response(
     *          response="user",
     *          description="修改后的账号信息",
     *          @SWG\Schema(ref="#/definitions/User")
     *     )
     * )
     */

    /**
     * 账号信息
     * @SWG\GET(
     *     path="/v1/user/{id}",
     *     tags={"User"},
     *     summary="账号信息",
     *     description="获取用户账号信息",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(name="id",type="integer", required=true, in="path",description="用户ID"),
     *     @SWG\Response(
     *          response="user",
     *          description="用户账号信息",
     *          @SWG\Schema(ref="#/definitions/User")
     *     )
     * )
     */

    /**
     * 删除账号
     * @SWG\DELETE(
     *     path="/v1/user/{id}",
     *     tags={"User"},
     *     summary="删除账号",
     *     description="",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(name="id",type="integer", required=true, in="path",description="用户ID"),
     *     @SWG\Response()
     * )
     */

    /**
     * 注册用户
     * @SWG\POST(
     *     path="/v1/user/signup",
     *     tags={"User"},
     *     summary="注册用户",
     *     description="",
     *     consumes={"application/x-www-form-urlencoded"},
     *     produces={"application/json"},
     *     @SWG\Parameter(name="username",type="string", required=true, in="formData",description="用户名"),
     *     @SWG\Parameter(name="password",type="string", required=true, in="formData",description="密码"),
     *     @SWG\Parameter(name="email",type="string", required=true, in="formData",description="邮箱"),
     *     @SWG\Response(
     *          response="200",
     *          description="用户账号信息",
     *          @SWG\Schema(ref="#/definitions/User")
     *     )
     * )
     */
    public function actionSignup(){
        $model = new SignupForm();
        $model->load(Yii::$app->request->post(),'');

        //参数检测
        if(!$model->validate())
            throw new BadRequestHttpException(ModelErrors::getError($model));

        //保存
        if ($model->signup())
            return $model;
        else
            throw new ServerErrorHttpException('fail');
    }

    /**
     * 用户信息
     * @SWG\GET(
     *     path="/v1/user/info/{id}",
     *     tags={"User"},
     *     summary="用户信息",
     *     description="获取用户信息",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(name="id",type="integer", required=true, in="path",description="用户ID"),
     *     @SWG\Response(
     *          response="info",
     *          description="用户信息",
     *          @SWG\Schema(ref="#/definitions/UserInfo")
     *     )
     * )
     */
    public function actionInfo($id){
        $model = User::findOne($id);
        if(!$model)
            throw new NotFoundHttpException("Object not found:$id");

        return $model->userInfo;
    }

    /**
     * 修改信息
     * @SWG\PUT(
     *     path="/v1/user/info/{id}",
     *     tags={"User"},
     *     summary="修改信息",
     *     description="修改账号信息",
     *     consumes={"application/x-www-form-urlencoded"},
     *     produces={"application/json"},
     *     @SWG\Parameter(name="id",type="integer", required=true, in="path",description="用户ID"),
     *     @SWG\Parameter(name="nickname",type="string", required=false, in="formData",description="用户昵称"),
     *     @SWG\Parameter(name="picture",type="string", required=false, in="formData",description="用户头像"),
     *     @SWG\Parameter(name="phone",type="string", required=false, in="formData",description="用户电话"),
     *     @SWG\Response(
     *          response="info",
     *          description="修改后的用户信息",
     *          @SWG\Schema(ref="#/definitions/UserInfo")
     *     )
     * )
     */
    public function actionInfoUpdate($id){
        $user = User::findOne($id);
        $model = $user->userInfo;
        $model->load(Yii::$app->request->post(),'');

        //参数检测
        if(!$model->validate())
            throw new BadRequestHttpException(ModelErrors::getError($model));

        //保存
        if ($model->save())
            return $model;
        else
            throw new ServerErrorHttpException('fail');
    }
}