<?php
namespace common\components;

use Yii;
use yii\base\Component;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use yii\web\ServerErrorHttpException;

class QiniuComponent extends Component
{
    /**
     * @var string
     */
    public $access_key = "k7bsKWF2Qw0mLFOcZfcZa69-khGg_8bCqDmMRyXd";
    public $secret_key = "VH-f4ueZOMYQ4dDS9vhgDzpSveXKVmM5q3BMtWLg";
    public $bucket = "english";
    public $bash_url = "http://cdn.e-l.ink";

    /**
     * 上传文件
     * @param $upfile
     * @param $path
     * @return mixed
     */
    public function upload($upfile,$path){
        //判断上传的文件
        $temp = explode(".", $upfile["name"]);

        //获取访问地址
        $ext = end($temp);
        $name = uniqid().".".$ext;
        $uploadname = "$path/$name";

        //获取文件地址
        $filename = $upfile["tmp_name"];

        //执行上传
        return $this->run($filename,$uploadname);
    }

    /**
     * 执行上传
     * @param $filename
     * @param $uploadname
     * @return string
     * @throws ServerErrorHttpException
     */
    private function run($filename,$uploadname){
        //获取授权
        $auth = new Auth($this->access_key, $this->secret_key);
        $bucket = $this->bucket;                    //就是七牛的应用名
        $token = $auth->uploadToken($bucket);       //获取上传的token

        //上传到七牛
        $uploadMgr = new UploadManager();
        list($ret, $err) = $uploadMgr->putFile($token, $uploadname, $filename);
        if ($err !== null){
            $error_msg = empty($err->response->error) ? "" : $err->response->error;
            $error_code = empty($err->response->statusCode) ? "" : $err->response->statusCode;
            if($error_msg && $error_code)
                throw new ServerErrorHttpException("qiniu uoload fail,$error_code:$error_msg");
        }
        else
            return $this->bash_url."/".$ret["key"];
    }
}