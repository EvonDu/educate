<?php
namespace api\controllers;

use Yii;
use yii\base\Event;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;

/**
 * Site controller
 */
class SiteController extends ActiveController
{
    public $modelClass = '';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return ArrayHelper::merge([
            //配置跨域
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                ],
            ],
        ], parent::behaviors());
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [];
    }

    /**
     * Index.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return "Api Index";
    }

    /**
     * Not Found.
     *
     * @return array
     */
    public function actionError(){
        return null;
    }
}
