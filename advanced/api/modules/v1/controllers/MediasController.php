<?php
namespace api\modules\v1\controllers;

use common\models\media\Pronunciation;
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
 * @SWG\Tag(name="Media",description="媒体库")
 */
class MediasController extends ActiveController
{
    public $modelClass = 'common\models\media\Pronunciation';

    public function behaviors()
    {
        return ArrayHelper::merge([
            //配置跨域
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                ],
            ],
        ], parent::behaviors());
    }

    public function actions()
    {
        $parent = parent::actions();
        unset($parent["view"]);
        return $parent;
    }

    /**
     * 获取读音
     * @SWG\GET(
     *     path="/v1/medias/pronunciations/{word}",
     *     tags={"Media"},
     *     summary="获取读音",
     *     description="根据单词获取读音",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter( name="word",type="string", required=true, in="path",description="单词" ),
     *     @SWG\Response( response="return",description="单词信息")
     * )
     */
    public function actionPronunciations($word){
        $model = Pronunciation::findOne(['word'=>$word]);
        if(!$model)
            throw new NotFoundHttpException("Not found:$word");

        return $model;
    }
}