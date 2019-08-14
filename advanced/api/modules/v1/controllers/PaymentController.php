<?php
namespace api\modules\v1\controllers;

use Yii;
use yii\helpers\Url;
use yii\log\Logger;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use api\lib\ApiRequest;
use api\lib\ApiController;
use evondu\wechat\lib\Xml;
use evondu\alipay\AlipayClient;
use evondu\wechat\WeChatClient;
use evondu\wechat\WeChatNotify;
use common\models\course\Course;
use common\models\order\Order;
use common\models\user\UserCourse;

/**
 * @OA\Tag(name="Payment",description="支付")
 */
class PaymentController extends ApiController
{
    public $modelClass = '';

    public function actions()
    {
        return [
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
        ];
    }

    /**
     * 订单查询
     * @OA\GET(
     *      path="/v1/payment/{order_no}",
     *      tags={"Payment"},
     *      summary="订单查询",
     *      description="查询完成的订单",
     *      @OA\Parameter(name="order_no", required=true, in="path", description="订单号", @OA\Schema(type="string")),
     *      @OA\Response(response="default", description="返回结果"),
     * )
     */
    public function actionView($order_no){
        $order = Order::findOne($order_no);
        if(empty($order)){
            throw new NotFoundHttpException("order not fund");
        }

        return $order;
    }

    /**
     * 支付宝支付
     * @OA\Post(
     *      path="/v1/payment/page",
     *      tags={"Payment"},
     *      summary="支付宝网页支付",
     *      description="获取支付宝网页支付地址",
     *      @OA\RequestBody(required=true, @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded", @OA\Schema(
     *              @OA\Property(description="用户ID", property="user_id", type="integer", default="1"),
     *              @OA\Property(description="课程ID", property="course_id", type="integer", default="26"),
     *              @OA\Property(description="支付完成返回地址", property="return_url", type="string", default="http://prime.thylink.cn/test/"),
     *          )
     *      )),
     *      @OA\Response(response="default", description="返回结果"),
     * )
     */
    public function actionPage(){
        //参数检测
        ApiRequest::checkPost(["user_id","course_id"]);
        $user_id = Yii::$app->request->post("user_id");
        $course_id = Yii::$app->request->post("course_id");
        $return_url = Yii::$app->request->post("return_url");

        //获取课程信息
        $course = Course::findOne($course_id);
        if(empty($course))
            throw new NotFoundHttpException("not found course.");

        //设置参数
        $data = [
            "user_id" => $user_id,
            "course_id" => $course_id,
            "course_name" => $course->name,
        ];

        //支付价格
        $price = max(1,$course->price);

        //获取支付地址
        $order_no = "CN".date("YmdHis").uniqid();
        $config = include Yii::getAlias("@common/config/alipay.php");
        $client = new AlipayClient($config);
        $notify_url = Url::to(["alipay-notify"],true);
        $url = $client->trade->payPage([
            "out_trade_no"      => $order_no,
            "total_amount"      => number_format($price/100, 2),
            "subject"           => $course->name,
            "body"              => $course->name,
            "passback_params"   => json_encode($data)
        ],$notify_url,$return_url);

        return $url;
    }

    /**
     * 微信支付
     * @OA\Post(
     *      path="/v1/payment/native",
     *      tags={"Payment"},
     *      summary="微信支付",
     *      description="获取微信支付二维码",
     *      @OA\RequestBody(required=true, @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded", @OA\Schema(
     *              @OA\Property(description="用户ID", property="user_id", type="integer", default="1"),
     *              @OA\Property(description="课程ID", property="course_id", type="integer", default="26"),
     *          )
     *      )),
     *      @OA\Response(response="default", description="返回结果"),
     * )
     */
    public function actionNative(){
        //参数检测
        ApiRequest::checkPost(["user_id","course_id"]);
        $user_id = Yii::$app->request->post("user_id");
        $course_id = Yii::$app->request->post("course_id");

        //获取课程信息
        $course = Course::findOne($course_id);
        if(empty($course))
            throw new NotFoundHttpException("not found course.");

        //设置参数
        $data = [
            "user_id" => $user_id,
            "course_id" => $course_id,
            "course_name" => $course->name,
        ];

        //支付价格
        $price = max(1,$course->price);

        //获取支付地址
        $order_no = "CN".date("YmdHis").uniqid();
        $config = include Yii::getAlias("@common/config/wechat.php");
        $client = new WeChatClient($config);
        $notify_url = Url::to(["wechat-notify"],true);
        $result = $client->payment->payNative([
            "body"              => $course->name,
            "out_trade_no"      => $order_no,
            'total_fee'         => $price,
            'attach'            => json_encode($data),
        ],$notify_url);

        //返回支付信息
        return [
            "order_no"      => $order_no,
            "code_url"      => $result["code_url"],
        ];
    }

    /**
     * 支付宝支付通知
     */
    public function actionAlipayNotify(){
        //参数设置
        $passback_params = json_decode($_POST["passback_params"]);

        //调试日志
        Yii::error(json_encode($_POST), Logger::LEVEL_ERROR);

        //保存订单
        $order = new Order();
        $order->order_no = $_POST["out_trade_no"];
        $order->channel = 2;
        $order->type = "ALIPAY";
        $order->openid = $_POST["seller_id"];
        $order->body = $passback_params->course_name;
        $order->amount_fee = $_POST["total_amount"] * 100;
        $order->trade_no = $_POST["trade_no"];
        $order->user_id = $passback_params->user_id;
        $order->course_id = $passback_params->course_id;
        $order->datetime = date("Y-m-d H:i:s");
        if(!$order->save())
            throw new ServerErrorHttpException("Create order error.");

        //完成购买操作
        $bool = UserCourse::buyCourse($order->user_id, $order->course_id);
        if(!$bool)
            throw new ServerErrorHttpException("Buy course error.");
    }

    /**
     * 微信支付通知
     */
    public function actionWechatNotify(){
        //获取数据
        $xml = file_get_contents("php://input");
        $data = Xml::xmlToArray($xml);

        //调试日志
        //Yii::error(json_encode($data), Logger::LEVEL_ERROR);

        //转化额外参数
        $attach_params = json_decode($data["attach"]);

        //保存订单
        $order = new Order();
        $order->order_no = $data["out_trade_no"];
        $order->channel = 1;
        $order->type = $data["trade_type"];
        $order->openid = $data["openid"];
        $order->body = $attach_params->course_name;
        $order->amount_fee = $data["total_fee"];
        $order->trade_no = $data["transaction_id"];
        $order->user_id = $attach_params->user_id;
        $order->course_id = $attach_params->course_id;
        $order->datetime = date("Y-m-d H:i:s");
        if(!$order->save())
            throw new ServerErrorHttpException("Create order error.");

        //完成购买操作
        $bool = UserCourse::buyCourse($order->user_id, $order->course_id);
        if(!$bool)
            throw new ServerErrorHttpException("Buy course error.");

        //应答通知
        WeChatNotify::reply(true);
    }


    /**
     * 微信网页授权地址
     * @OA\Post(
     *      path="/v1/payment/wechat-auth-url",
     *      tags={"Payment"},
     *      summary="微信网页授权地址",
     *      description="获取微信网页授权地址",
     *      @OA\RequestBody(required=true, @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded", @OA\Schema(
     *              @OA\Property(description="授权返回地址", property="redirectUrl", type="string", default="http://www.baidu.com"),
     *          )
     *      )),
     *      @OA\Response(response="default", description="返回结果"),
     * )
     */
    public function actionWechatAuthUrl(){
        //参数检测
        ApiRequest::checkPost(["redirectUrl"]);
        $redirectUrl = Yii::$app->request->post("redirectUrl");
        $config = include Yii::getAlias("@common/config/wechat.php");
        $client = new WeChatClient($config);
        $url = $client->auth->getAuthUrl($redirectUrl);

        //返回结果
        return $url;
    }

    /**
     * 微信授权
     * @OA\Post(
     *      path="/v1/payment/wechat-auth",
     *      tags={"Payment"},
     *      summary="微信授权",
     *      description="进行微信授权",
     *      @OA\RequestBody(required=true, @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded", @OA\Schema(
     *              @OA\Property(description="微信授权码", property="code", type="string", default=""),
     *          )
     *      )),
     *      @OA\Response(response="default", description="返回结果"),
     * )
     */
    public function actionWechatAuth(){
        //参数检测
        ApiRequest::checkPost(["code"]);
        $code = Yii::$app->request->post("code");

        //进行认证
        $config = include Yii::getAlias("@common/config/wechat.php");
        $client = new WeChatClient($config);
        $client->auth->oauthByCode($code);
        $openid = $client->auth->getOpenid();

        //判断授权是否成功
        if(empty($openid))
            throw new BadRequestHttpException("授权失败,code无效或过期");

        //返回结果
        return $openid;
    }

    /**
     * 微信支付(JSAPI)
     * @OA\Post(
     *      path="/v1/payment/jsapi",
     *      tags={"Payment"},
     *      summary="微信支付(JSAPI)",
     *      description="获取微信JSAPI支付配置",
     *      @OA\RequestBody(required=true, @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded", @OA\Schema(
     *              @OA\Property(description="OPENID", property="openid", type="omR1B1SsRSJNTFwK_KSsf5D_Jy-U", default="1"),
     *              @OA\Property(description="支付页面URL", property="url", type="integer", default="http://www.baidu.com"),
     *          )
     *      )),
     *      @OA\Response(response="default", description="返回结果"),
     * )
     */
    public function actionJsapi(){
        //获取参数
        ApiRequest::checkPost(["url","openid"]);
        $url = Yii::$app->request->post("url");
        $openid = Yii::$app->request->post("openid");

        //创建微信客户端
        $config = include Yii::getAlias("@common/config/wechat.php");
        $client = new WeChatClient($config);

        //获取微信JSSDK签署
        $signature = $client->jssdk->getSignature($url);

        //统一下单
        $notify_url = Url::to(["wechat-notify"],true);
        $payConfig = $client->payment->payJsapi([
            "body"          => "test",
            "out_trade_no"  => time(),
            "total_fee"     => 1,
            "openid"        => $openid
        ],$notify_url);

        //返回结果
        return [
            "signature" => $signature,
            "payConfig" => $payConfig
        ];
    }
}