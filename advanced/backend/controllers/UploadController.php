<?php

namespace backend\controllers;

use common\lib\Upload;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * OptionController implements the CRUD actions for Option model.
 */
class UploadController extends Controller
{
    //关闭CSRF
    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function uploadPath(){
        //return "upload";
        return Yii::getAlias("@upload");
    }

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
     * 单文件上传
     */
    public function actionFile()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            list($path,$src) = Upload::upload_file($file,$this->uploadPath());
            Upload::sentApiResult(0,"",$src);
        }
        else{
            Upload::sentApiResult(0,"image could not be saved.",null);
        }
    }

    /**
     * 单上传文件(Base64字符串)
     * 必须存在$_POST['base64']
     */
    public function actionBase64(){
        if (isset($_POST['base64'])) {
            $base64 = $_POST['base64'];
            list($path,$src) = Upload::upload_base64($base64,$this->uploadPath());
            Upload::sentApiResult(0,"",$src);
        }
        else{
            Upload::sentApiResult(0,"image could not be saved.",null);
        }
    }

    /**
     * 读取文件资源
     * @param null $src
     * @throws NotFoundHttpException
     */
    public function actionGet($src = null){
        $fullname = $this->uploadPath()."/$src";
        if(!file_exists($fullname) || is_dir($fullname))
            throw new \yii\web\NotFoundHttpException('file not found');

        $response = Yii::$app->getResponse();
        $response->headers->set('Content-Type', mime_content_type($fullname));
        $response->format = yii\web\Response::FORMAT_RAW;
        $response->stream = fopen($fullname, 'r');
    }
}
