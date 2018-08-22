<?php
namespace common\lib\inherit\controller;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Auth controller
 * 这个控制器基类，只为了实现授权认证部分。
 * 使用方法：
 *      1、继承这个控制器类
 *      2、确保behaviors方法不被重写
 *      3、开启认证：$enableAccess = true；
 * 事项原理：
 *      其会根据当前访问把，把访问控制器和方法，设置到Yii的access过滤器的rules。
 *      其会判断当前用户是否具有：控制器/方法 的权限，如果没有则不能访问。
 *
 */
class AuthController extends Controller
{
    /**
     * {@inheritdoc}
     */
    protected $enableAccess = true;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        if($this->enableAccess){
            $controller = Yii::$app->controller->id;
            $function = Yii::$app->controller->action->id;
            return array_merge([
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ["$function"],
                            'roles' => ["$controller/$function"],
                        ],
                    ],
                ],
            ],parent::behaviors());
        }
        else{
            return parent::behaviors();
        }
    }
}
