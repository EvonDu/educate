<?php
namespace api\modules\v1\controllers;

use api\lib\ApiController;
use api\lib\ApiRequest;
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