<?php

namespace backend\controllers;

use common\lib\base\UploadForm;
use common\lib\QiniuUpload;
use common\lib\base\Upload;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * OptionController implements the CRUD actions for Option model.
 */
class UEditorController extends Controller
{
    //关闭CSRF
    public $enableCsrfValidation = false;

    public function init(){
        Yii::$app->response->format = Response::FORMAT_JSON;
    }

    //config
    public function actionIndex(){
        $action = Yii::$app->request->get("action");

        switch ($action){
            case "config":
                return $this->actionConfig();
                break;
            case "uploadimage":
                return $this->actionUpload();
                break;
        }
    }

    //返回配置
    public function actionConfig(){
        echo json_encode([
            "imageActionName" => "uploadimage",
            "imagePath" => "/ueditor/php/",
            "imageFieldName" => "upfile",
            "imageMaxSize" => 2048000,
            "imageAllowFiles" => [".png", ".jpg", ".jpeg", ".gif", ".bmp"],
            "imageCompressEnable" => true, /* 是否压缩图片,默认是true */
            "imageCompressBorder" => 1600, /* 图片压缩最长边限制 */
            "imageInsertAlign" => "none", /* 插入的图片浮动方式 */
            "imageUrlPrefix" => "", /* 图片访问路径前缀 */
            "imagePathFormat" => "/ueditor/php/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}",
        ]);
    }

    //上传图片
    public function actionUpload(){
        $model = new UploadForm();
        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstanceByName('upfile');
            if($model->upload()){
                echo json_encode([
                    "state"=> "SUCCESS",
                    "url"=> $model->getUrl(),
                    "title"=> "upload.jpg",
                    "original"=> "upload.jpg",
                ]);
                die;
            }
        }

        //失败时返回
        echo json_encode([
            "state"=> "ERROR",
            "message"=> json_encode($model->errors)
        ]);
        die;
    }
}
