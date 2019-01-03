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
 * @SWG\Tag(name="Page",description="页面")
 */
class PagesController extends ApiController
{
    public $modelClass = 'common\models\page\Page';

    public function actions()
    {
        return [];
    }

    /**
     * 全部页面
     * @SWG\GET(
     *     path="/v1/pages",
     *     tags={"Page"},
     *     summary="全部页面",
     *     description="全部页面",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response( response="return",description="页面列表")
     * )
     */
    public function actionIndex(){
        $list = [];
        $list[] = Page::getPage("Methods");
        $list[] = Page::getPage("TermsOfUse");
        $list[] = Page::getPage("Privacy");
        $list[] = Page::getPage("Support");
        $list[] = Page::getPage("CopyrightPolicy");
        $list[] = Page::getPage("AboutUs");
        return $list;
    }

    /**
     * 关于我们
     * @SWG\GET(
     *     path="/v1/pages/about-us",
     *     tags={"Page"},
     *     summary="关于我们",
     *     description="关于我们",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response( response="return",description="关于我们")
     * )
     */
    public function actionAboutUs(){
        $model = Page::getPage("AboutUs");
        return $model;
    }

    /**
     * 公司简介
     * @SWG\GET(
     *     path="/v1/pages/company-profile",
     *     tags={"Page"},
     *     summary="公司简介",
     *     description="公司简介",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response( response="return",description="公司简介")
     * )
     */
    public function actionCompanyProfile(){
        $model = Page::getPage("CompanyProfile");
        return $model;
    }

    /**
     * 用户协议
     * @SWG\GET(
     *     path="/v1/pages/user-agreement",
     *     tags={"Page"},
     *     summary="用户协议",
     *     description="用户协议",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response( response="return",description="用户协议")
     * )
     */
    public function actionUserAgreement(){
        $model = Page::getPage("UserAgreement");
        return $model;
    }

    /**
     * 支付协议
     * @SWG\GET(
     *     path="/v1/pages/payment-agreement",
     *     tags={"Page"},
     *     summary="支付协议",
     *     description="支付协议",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response( response="return",description="支付协议")
     * )
     */
    public function actionPaymentAgreement(){
        $model = Page::getPage("PaymentAgreement");
        return $model;
    }

    /**
     * 学习教程
     * @SWG\GET(
     *     path="/v1/pages/tutorial",
     *     tags={"Page"},
     *     summary="学习教程",
     *     description="学习教程",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response( response="return",description="学习教程")
     * )
     */
    public function actionTutorial(){
        $model = Page::getPage("Tutorial");
        return $model;
    }

    /**
     * 学习模式
     * @SWG\GET(
     *     path="/v1/pages/methods",
     *     tags={"Page"},
     *     summary="学习模式",
     *     description="学习模式",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response( response="return",description="学习模式")
     * )
     */
    public function actionMethods(){
        $model = Page::getPage("Methods");
        return $model;
    }

    /**
     * 使用条款
     * @SWG\GET(
     *     path="/v1/pages/terms-of-use",
     *     tags={"Page"},
     *     summary="使用条款",
     *     description="使用条款",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response( response="return",description="使用条款")
     * )
     */
    public function actionTermsOfUse(){
        $model = Page::getPage("TermsOfUse");
        return $model;
    }

    /**
     * 私隐
     * @SWG\GET(
     *     path="/v1/pages/privacy",
     *     tags={"Page"},
     *     summary="私隐",
     *     description="私隐",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response( response="return",description="私隐")
     * )
     */
    public function actionPrivacy(){
        $model = Page::getPage("Privacy");
        return $model;
    }

    /**
     * 服务支持
     * @SWG\GET(
     *     path="/v1/pages/support",
     *     tags={"Page"},
     *     summary="服务支持",
     *     description="服务支持",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response( response="return",description="服务支持")
     * )
     */
    public function actionSupport(){
        $model = Page::getPage("Support");
        return $model;
    }
}