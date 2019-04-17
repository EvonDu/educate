<?php
namespace api\modules\v1\controllers;

use api\lib\ApiRequest;
use common\models\course\Course;
use common\models\order\Order;
use common\models\user\UserCourse;
use evondu\alipay\AlipayClient;
use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\log\Logger;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;
use api\lib\ApiController;

/**
 * @SWG\Tag(name="Payment",description="支付")
 */
class PaymentController extends ApiController
{
    public $modelClass = 'common\models\order\Order';

    /**
     * 支付宝支付
     * @SWG\POST(
     *     path="/v1/payment/page",
     *     tags={"Payment"},
     *     summary="支付宝网页支付",
     *     description="获取支付宝网页支付地址",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="user_id",type="integer", required=true, in="formData",description="用户ID", default="1"),
     *     @SWG\Parameter( name="course_id",type="integer", required=true, in="formData",description="课程ID", default="26"),
     *     @SWG\Parameter( name="return_url",type="string", required=false, in="formData",description="支付完成返回地址", default="http://prime.thylink.cn/test/"),
     *     @SWG\Response( response="return",description="支付地址")
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
            "course_id" => $course_id
        ];

        //获取支付地址
        $config = include Yii::getAlias("@common/config/alipay.php");
        $client = new AlipayClient($config);
        $notify_url = Url::to(["page-notify"],true);
        $url = $client->trade->payPage([
            "out_trade_no"      => time(),
            "total_amount"      => "0.01",
            "subject"           => "标题",
            "body"              => "支付内容",
            "passback_params"   => json_encode($data)
        ],$notify_url,$return_url);

        return $url;
    }

    /**
     * 支付宝网页支付通知
     */
    public function actionPageNotify(){
        //参数设置
        $passback_params = json_decode($_POST["passback_params"]);

        //保存订单
        $order = new Order();
        $order->order_no = $_POST["out_trade_no"];
        $order->channel = 2;
        $order->type = "PAGE";
        $order->openid = $_POST["seller_id"];
        $order->body = $_POST["body"];
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
}