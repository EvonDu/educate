<?php

namespace backend\controllers\email;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\models\email\EmailPushForm;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PushController extends Controller
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
     * 发送邮箱
     * @return string|\yii\web\Response
     */
    public function actionIndex(){
        //获取首页模型
        $model = new EmailPushForm();

        //如果有表单提交则保存
        if ($model->load(Yii::$app->request->post()) && $model->push()) {
            return $this->redirect(['success']);
        }

        //调用视图
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * 发送成功
     * @return string
     */
    public function actionSuccess(){
        //调用视图
        return $this->render('success', []);
    }
}
