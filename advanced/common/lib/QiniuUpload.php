<?php
namespace common\lib;

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class QiniuUpload{
    /**
     * @var
     */
    static private $config;

    /**
     * init
     */
    static private function init(){
        self::$config = include __DIR__."/../config/qiniu.php";
    }

    /**
     * @param $upfile
     * @param $path
     * @return null|string
     */
    static public function upload($upfile,$path){
        //判断上传的文件
        $temp = explode(".", $upfile["name"]);

        //获取访问地址
        $ext = end($temp);
        $name = uniqid().".".$ext;
        $uploadname = "$path/$name";

        //获取文件地址
        $filename = $upfile["tmp_name"];

        //执行上传
        return self::run($filename,$uploadname);
    }

    /**
     * @param $filename
     * @param $uploadname
     * @return null|string
     */
    static private function run($filename,$uploadname){
        //初始化
        self::init();

        //获取授权
        $accessKey = self::$config['AccessKey'];
        $secretKey = self::$config['SecretKey'];
        $auth = new Auth($accessKey, $secretKey);
        $bucket = self::$config['Bucket'];;//就是七牛的应用名
        $token = $auth->uploadToken($bucket);//获取上传的token

        //上传到七牛
        $uploadMgr = new UploadManager();
        list($ret, $err) = $uploadMgr->putFile($token, $uploadname, $filename);
        if ($err !== null)
            return null;
        else
            return self::$config['Url']."/$uploadname";
    }
}