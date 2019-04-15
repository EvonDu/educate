<?php
namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;
use api\lib\ApiController;
use api\lib\ModelErrors;
use common\models\page\Page;

/**
 * @SWG\Tag(name="Payment",description="支付")
 */
class PaymentController extends ApiController
{
    public $modelClass = 'common\models\page\Page';

    public function actions()
    {
        return [];
    }

    public function actionIndex(){
        $list = [];
        return $list;
    }

    /**
     * 支付宝支付
     * @SWG\GET(
     *     path="/v1/payment/alipay",
     *     tags={"Payment"},
     *     summary="支付宝支付",
     *     description="获取支付宝支付地址",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response( response="return",description="支付地址")
     * )
     */
    public function actionAlipay(){
        $list = [];
        $list[] = Page::getPage("Methods");
        $list[] = Page::getPage("TermsOfUse");
        $list[] = Page::getPage("Privacy");
        $list[] = Page::getPage("Support");
        $list[] = Page::getPage("CopyrightPolicy");
        $list[] = Page::getPage("AboutUs");
        return $list;
    }
}