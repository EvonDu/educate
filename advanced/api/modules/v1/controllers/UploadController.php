<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\helpers\Url;
use api\lib\ApiController;
use common\lib\base\Upload;

/**
 * @OA\Tag(name="Common",description="通用")
 */
class UploadController extends ApiController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [];
    }

    /**
     * 设置上传路径
     * @inheritdoc
     */
    public function uploadPath(){
        //return "upload";
        return Yii::getAlias("@upload");
    }

    /**
     * 文件上传
     * @OA\Post(
     *      path="/v1/upload/file",
     *      tags={"Common"},
     *      summary="文件上传",
     *      description="文件上传",
     *      @OA\RequestBody(required=true, @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              @OA\Property(description="上传文件", property="file", type="file"),
     *          )
     *      )),
     *      @OA\Response(response="default", description="返回结果"),
     * )
     */
    public function actionFile()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            list($path,$src) = Upload::upload_file($file,$this->uploadPath());
            $result = Url::to(['get',"src"=>$src],true);
            $result = urldecode($result);
            return $result;
        }
        else{
            throw new BadRequestHttpException("missing parameter [file]");
        }
    }

    /**
     * 文件上传(Base64字符串)
     * @OA\Post(
     *      path="/v1/upload/base64",
     *      tags={"Common"},
     *      summary="文件上传(Base64字符串)",
     *      description="以Base64的方式上传文件",
     *      @OA\RequestBody(required=true, @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(
     *              @OA\Property(description="上传文件的Base64字符串", property="base64", type="string"),
     *          )
     *      )),
     *      @OA\Response(response="default", description="返回结果"),
     * )
     */
    public function actionBase64(){
        if (isset($_POST['base64'])) {
            $base64 = $_POST['base64'];
            list($path,$src) = Upload::upload_base64($base64,$this->uploadPath());
            $result = Url::to(['get',"src"=>$src],true);
            $result = urldecode($result);
            return $result;
        }
        else{
            throw new BadRequestHttpException("missing parameter [base64]");
        }
    }

    /**
     * 获取文件
     * @OA\Get(
     *      path="/v1/upload/get/{src}",
     *      tags={"Common"},
     *      summary="获取文件",
     *      description="获取文件",
     *      @OA\Parameter(name="src", required=true, in="path",description="文件服务器路径", @OA\Schema(type="string")),
     *      @OA\Response(response="default", description="返回结果")
     * )
     */
    public function actionGet($src = null){
        $fullname = $this->uploadPath()."/$src";
        if(!file_exists($fullname) || is_dir($fullname))
            throw new NotFoundHttpException('file not found');

        $response = Yii::$app->getResponse();
        $response->headers->set('Content-Type', mime_content_type($fullname));
        $response->format = yii\web\Response::FORMAT_RAW;
        $response->stream = fopen($fullname, 'r');
    }
}
