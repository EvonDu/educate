<?php
namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;
use common\models\user\User;
use common\models\user\SignupForm;

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
     * @api {get} /v1/user 用户列表
     * @apiName list
     * @apiDescription 用户列表
     * @apiGroup User
     * @apiVersion 1.0.0
     *
     * @apiSuccess (返回参数) {Number} id           ID
     * @apiSuccess (返回参数) {String} username     用户名
     * @apiSuccess (返回参数) {String} email        邮箱
     * @apiSuccess (返回参数) {Number} created_at   创建时间（时间戳）
     * @apiSuccess (返回参数) {Number} created_at   更新时间（时间戳）
     *
     *
     * @apiSuccessExample 成功返回:
     * {
     *      "state":{
     *          "code":0,
     *          "massage":""
     *      },
     *      "data":[
     *          {
     *              "id": 1,
     *              "username": "user",
     *              "auth_key": "wD6zTurnBHhA4Z3mCYW0YDg2ydJkfPWy",
     *              "password_hash": "$2y$13$h7N0xwgbNWVxLdLmXbVRkO5uCaccjBehHjppTNqAqmPCnDi/1.0UK",
     *              "password_reset_token": null,
     *              "email": "user@yii.com",
     *              "status": 10,
     *              "created_at": 1524535976,
     *              "updated_at": 1524535976
     *          },
     *          {
     *              "id": 2,
     *              "username": "user2",
     *              "auth_key": "zFDjF_SSeQYc6eY7fEaGDFXcZBCDnse8",
     *              "password_hash": "$2y$13$5YLa.bYAihZi6uW0LSI.fOQBcWPksCnAMhdOngd7Xx6uapGqbtH4u",
     *              "password_reset_token": null,
     *              "email": "user2@yii.com",
     *              "status": 10,
     *              "created_at": 1524552822,
     *              "updated_at": 1524552822
     *           }
     *      ]
     * }
     *
     * @apiErrorExample 失败返回:
     * {
     *      "state":{
     *          "code":500,
     *          "massage":"fail."
     *      },
     *      "data":null
     * }
     *
     */

    /**
     * 修改状态
     * @api {put} /v1/user/<id> 修改状态
     * @apiName update
     * @apiDescription 修改状态
     * @apiGroup User
     * @apiVersion 1.0.0
     *
     * @apiHeader (Http Headers) Content-Type application/x-www-form-urlencoded
     *
     * @apiParam (请求参数) {Number} status 用户状态（可选）[10：正常状态 | 0：软删除]
     *
     * @apiSuccess (返回参数) {Number} id           ID
     * @apiSuccess (返回参数) {String} username     用户名
     * @apiSuccess (返回参数) {String} email        邮箱
     * @apiSuccess (返回参数) {Number} created_at   创建时间（时间戳）
     * @apiSuccess (返回参数) {Number} created_at   更新时间（时间戳）
     *
     *
     * @apiSuccessExample 成功返回:
     * {
     *      "state":{
     *          "code":0,
     *          "massage":""
     *      },
     *      "data":{
     *          "id":1,
     *          "username":"user",
     *          "auth_key":"wD6zTurnBHhA4Z3mCYW0YDg2ydJkfPWy",
     *          "password_hash":"$2y$13$lNEtmErZ5xSDZbNQPBAqk.efwqOSqQjgVGyGumztIJEwoYYMme7RG",
     *          "password_reset_token":null,
     *          "email":"user@yii.com",
     *          "status":10,
     *          "created_at":1524535976,
     *          "updated_at":1525741342
     *      }
     * }
     *
     * @apiErrorExample 失败返回:
     * {
     *      "state":{
     *          "code":500,
     *          "massage":"fail."
     *      },
     *      "data":null
     * }
     *
     */

    /**
     * 用户概要
     * @api {get} /v1/user/<id> 用户概要
     * @apiName view
     * @apiDescription 用户概要
     * @apiGroup User
     * @apiVersion 1.0.0
     *
     * @apiSuccess (返回参数) {Number} id ID
     * @apiSuccess (返回参数) {String} username 用户名
     * @apiSuccess (返回参数) {String} email 邮箱
     * @apiSuccess (返回参数) {Number} created_at 创建时间（时间戳）
     * @apiSuccess (返回参数) {Number} created_at 更新时间（时间戳）
     *
     *
     * @apiSuccessExample 成功返回:
     * {
     *      "state":{
     *          "code":0,
     *          "massage":""
     *      },
     *      "data":{
     *          "id":1,
     *          "username":"user",
     *          "auth_key":"wD6zTurnBHhA4Z3mCYW0YDg2ydJkfPWy",
     *          "password_hash":"$2y$13$h7N0xwgbNWVxLdLmXbVRkO5uCaccjBehHjppTNqAqmPCnDi/1.0UK",
     *          "password_reset_token":null,
     *          "email":"user@yii.com",
     *          "status":10,
     *          "created_at":1524535976,
     *          "updated_at":1524535976
     *      }
     * }
     *
     * @apiErrorExample 失败返回:
     * {
     *      "state":{
     *          "code":500,
     *          "massage":"fail."
     *      },
     *      "data":null
     * }
     *
     */

    /**
     * 删除用户
     * @api {delete} /v1/user/<id> 删除用户
     * @apiName delete
     * @apiDescription 删除用户
     * @apiGroup User
     * @apiVersion 1.0.0
     *
     *
     * @apiSuccessExample 成功返回:
     * {
     *      "state":{
     *          "code":0,
     *          "massage":""
     *      },
     *      "data":null
     * }
     *
     * @apiErrorExample 失败返回:
     * {
     *      "state":{
     *          "code":500,
     *          "massage":"fail."
     *      },
     *      "data":null
     * }
     *
     */

    /**
     * 注册用户
     * @api {post} /v1/user/signup 注册用户
     * @apiName signup
     * @apiDescription 注册用户
     * @apiGroup User
     * @apiVersion 1.0.0
     *
     * @apiHeader (Http Headers) Content-Type application/x-www-form-urlencoded
     *
     * @apiParam (请求参数) {String} username   用户名
     * @apiParam (请求参数) {String} password   密码
     * @apiParam (请求参数) {String} email      邮箱
     *
     * @apiSuccessExample 成功返回:
     * {
     *      "state":{
     *          "code":0,
     *          "massage":""
     *      },
     *      "data":{
     *          "username":"user",
     *          "email":"user@yii.com",
     *          "password":"123456"
     *      }
     * }
     *
     * @apiErrorExample 失败返回:
     * {
     *      "state":{
     *          "code":400,
     *          "massage":'{"username":["This username has already been taken."],"email":["This email address has already been taken."]}'
     *      },
     *      "data":null
     * }
     *
     */
    public function actionSignup(){
        $model = new SignupForm();
        $model->load(Yii::$app->request->post(),'');

        //参数检测
        if(!$model->validate())
            throw new BadRequestHttpException(json_encode($model->errors));

        //保存
        if ($model->signup())
            return $model;
        else
            throw new ServerErrorHttpException('fail');
    }

    /**
     * 用户信息
     * @api {get} /v1/user/info/<id> 用户信息
     * @apiName info
     * @apiDescription 用户信息
     * @apiGroup User
     * @apiVersion 1.0.0
     *
     * @apiSuccess (返回参数) {Number} id           ID
     * @apiSuccess (返回参数) {Number} user_id      用户ID
     * @apiSuccess (返回参数) {String} nickname     昵称
     * @apiSuccess (返回参数) {String} picture      头像
     * @apiSuccess (返回参数) {String} phone        电话
     *
     *
     * @apiSuccessExample 成功返回:
     * {
     *      "state":{
     *          "code":0,
     *          "massage":""
     *      },
     *      "data":{
     *          "id":1,
     *          "user_id":1,
     *          "nickname":"用户",
     *          "picture":"upload/20180429/5ae5960d337fb.jpeg",
     *          "phone":"123456"}
     * }
     *
     * @apiErrorExample 失败返回:
     * {
     *      "state":{
     *          "code":500,
     *          "massage":"fail."
     *      },
     *      "data":null
     * }
     *
     */
    public function actionInfo($id){
        $model = User::findOne($id);
        if(!$model)
            throw new NotFoundHttpException("Object not found:$id");

        return $model->userInfo;
    }

    /**
     * 修改信息
     * @api {put} /v1/user/info/<id> 修改信息
     * @apiName info-update
     * @apiDescription 修改信息
     * @apiGroup User
     * @apiVersion 1.0.0
     *
     * @apiHeader (Http Headers) Content-Type application/x-www-form-urlencoded
     *
     * @apiParam (请求参数) {String} nickname       昵称
     * @apiParam (请求参数) {String} picture        头像
     * @apiParam (请求参数) {String} phone          电话
     *
     * @apiSuccess (返回参数) {Number} id           ID
     * @apiSuccess (返回参数) {Number} user_id      用户ID
     * @apiSuccess (返回参数) {String} nickname     昵称
     * @apiSuccess (返回参数) {String} picture      头像
     * @apiSuccess (返回参数) {String} phone        电话
     *
     *
     * @apiSuccessExample 成功返回:
     * {
     *      "state":{
     *          "code":0,
     *          "massage":""
     *      },
     *      "data":{
     *          "id":1,
     *          "user_id":1,
     *          "nickname":"用户",
     *          "picture":"upload/20180429/5ae5960d337fb.jpeg",
     *          "phone":"123456"
     *      }
     * }
     *
     * @apiErrorExample 失败返回:
     * {
     *      "state":{
     *          "code":500,
     *          "massage":"fail."
     *      },
     *      "data":null
     * }
     *
     */
    public function actionInfoUpdate($id){
        $user = User::findOne($id);
        $model = $user->userInfo;
        $model->load(Yii::$app->request->post(),'');

        //参数检测
        if(!$model->validate())
            throw new BadRequestHttpException(json_encode($model->errors));

        //保存
        if ($model->save())
            return $model;
        else
            throw new ServerErrorHttpException('fail');
    }
}