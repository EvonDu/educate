<?php

namespace backend\controllers\page;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\page\Page;
use common\models\page\PageSearch;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * 关于我们
     * @return string|\yii\web\Response
     */
    public function actionAboutUs(){
        $model = Page::getPage("AboutUs");

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * 公司介绍
     * @return string|\yii\web\Response
     */
    public function actionCompanyProfile(){
        $model = Page::getPage("CompanyProfile");

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * 用户协议
     * @return string|\yii\web\Response
     */
    public function actionUserAgreement(){
        $model = Page::getPage("UserAgreement");

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * 支付协议
     * @return string|\yii\web\Response
     */
    public function actionPaymentAgreement(){
        $model = Page::getPage("PaymentAgreement");

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * 学习教程
     * @return string|\yii\web\Response
     */
    public function actionTutorial(){
        $model = Page::getPage("Tutorial");

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * 学习模式
     * @return string|\yii\web\Response
     */
    public function actionMethods(){
        $model = Page::getPage("Methods");

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * 使用条款
     * @return string|\yii\web\Response
     */
    public function actionTermsOfUse(){
        $model = Page::getPage("TermsOfUse");

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * 私隐条款
     * @return string|\yii\web\Response
     */
    public function actionPrivacy(){
        $model = Page::getPage("Privacy");

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * 服务支持
     * @return string|\yii\web\Response
     */
    public function actionSupport(){
        $model = Page::getPage("Support");

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
