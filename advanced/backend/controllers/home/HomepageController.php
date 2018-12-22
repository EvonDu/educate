<?php

namespace backend\controllers\home;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\homepage\Homepage;

/**
 * PageController implements the CRUD actions for Page model.
 */
class HomepageController extends Controller
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
     * 首页设置
     * @return string|\yii\web\Response
     */
    public function actionIndex(){
        //获取首页模型
        $model = Homepage::getModel();

        //如果有表单提交则保存
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->goHome();
        }

        //调用视图
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
