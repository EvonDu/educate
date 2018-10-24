<?php

namespace backend\controllers\page;

use Yii;
use common\models\page\Page;
use common\models\page\PageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
}
