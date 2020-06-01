<?php
namespace api\modules\v1\controllers;

use yii\web\NotFoundHttpException;
use api\lib\ApiController;
use common\models\media\Pronunciation;

/**
 * @OA\Tag(name="Media",description="媒体库")
 */
class MediasController extends ApiController
{
    public $modelClass = 'common\models\media\Pronunciation';

    public function actions()
    {
        $parent = parent::actions();
        unset($parent["view"]);
        return $parent;
    }

    /**
     * 获取读音
     * @OA\Get(
     *      path="/v1/medias/pronunciations/{word}",
     *      tags={"Media"},
     *      summary="获取读音",
     *      description="根据单词获取读音",
     *      @OA\Parameter(name="word", required=true, in="path",description="单词", @OA\Schema(type="string")),
     *      @OA\Response(response="default", description="返回结果")
     * )
     */
    public function actionPronunciations($word){
        $model = Pronunciation::findOne(['word'=>$word]);
        if(!$model)
            throw new NotFoundHttpException("Not found:$word");

        return $model;
    }
}