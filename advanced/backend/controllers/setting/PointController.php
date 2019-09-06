<?php

namespace backend\controllers\setting;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\models\setting\Setting;

/**
 * Class PointController
 * @package backend\controllers\page
 */
class PointController extends Controller
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
     * @return string
     */
    public function actionIndex(){
        //获取设置项
        $items = [
            "point_fix_register"        => (int)Setting::getItem("point_fix_register") ?: 0,
            "point_percent_invitee_buy" => (int)Setting::getItem("point_percent_invitee_buy") ?: 0,
            "point_percent_buy"         => (int)Setting::getItem("point_percent_buy") ?: 0,
            "point_percent_complete"    => (int)Setting::getItem("point_percent_complete") ?: 0,
        ];

        //处理提交数据
        if(Yii::$app->request->isPost){
            Setting::setItem("point_fix_register", Yii::$app->request->post("point_fix_register", 0));
            Setting::setItem("point_percent_invitee_buy", Yii::$app->request->post("point_percent_invitee_buy", 0));
            Setting::setItem("point_percent_buy", Yii::$app->request->post("point_percent_buy", 0));
            Setting::setItem("point_percent_complete", Yii::$app->request->post("point_percent_complete", 0));
            return $this->redirect(['index']);
        }

        //调用视图
        return $this->render('index', [
            'items' => $items,
        ]);
    }
}
