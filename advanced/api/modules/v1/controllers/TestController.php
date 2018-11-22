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

/**
 * !!!!!@SWG\Tag(name="Test",description="测试")
 */
class TestController extends ApiController
{
    public $modelClass = 'common\models\user\User';

    public function actions()
    {
        return [];
    }
}