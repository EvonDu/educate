<?php
namespace api\modules\v1\controllers;

use api\lib\ApiController;
use api\lib\ApiRequest;
use common\models\page\Page;
use common\models\setting\Setting;
use common\models\user\UserCourse;
use common\models\user\UserCourseSearch;
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
        $list[] = Page::getPage("AboutUs");
        $list[] = Page::getPage("CompanyProfile");
        $list[] = Page::getPage("UserAgreement");
        $list[] = Page::getPage("PaymentAgreement");
        $list[] = Page::getPage("Tutorial");
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
}