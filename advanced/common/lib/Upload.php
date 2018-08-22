<?php
namespace common\lib;

use Yii;
use yii\helpers\Url;

class Upload{
    /**
     * 上传文件函数
     * @param $upfile
     * @return string
     */
    static public function upload_file($upfile,$path="upload",$name=null)
    {
        //判断上传的文件
        $temp = explode(".", $upfile["name"]);

        //判断是否有错
        if ($upfile["error"] > 0) return null;

        //生成文件路径
        $datepath = date("Ymd",time());                             //生成日期
        $dirpath = "$path/$datepath";                                       //相对路径
        self::mkdirs($dirpath);                                             //建立文件夹(如果不存在)

        //获取访问地址
        $ext = end($temp);                                                  //获取文件后缀名
        $name = ($name?$name:uniqid()).".".$ext;                            //文件名
        $filename = "$dirpath/$name";                                       //文件路径名
        $srcpath = "$datepath/$name";                                       //生成相对路径

        //保存文件
        if (!file_exists($filename))
            move_uploaded_file($upfile["tmp_name"], $filename);

        //返回数据
        return [$filename,$srcpath];
    }

    /**
     * 上传Base64函数
     * @param $base64
     * @return null|string
     */
    static public function upload_base64($base64,$path="upload",$name=null){
        if (strpos($base64, 'data:image/jpeg;base64,') === 0) {
            $base64 = str_replace('data:image/jpeg;base64,', '', $base64);
            $ext = 'jpeg';
        }
        if (strpos($base64, 'data:image/png;base64,') === 0) {
            $base64 = str_replace('data:image/png;base64,', '', $base64);
            $ext = 'png';
        }

        //获取图片文件内容
        $base64 = str_replace(' ', '+', $base64);
        $data = base64_decode($base64);

        //生成文件路径
        $datepath = date("Ymd",time());                             //生成日期
        $dirpath = "$path/$datepath";                                       //相对路径
        self::mkdirs($dirpath);                                             //建立文件夹(如果不存在)

        //设置文件名
        $name = ($name?$name:uniqid()).".".$ext;                            //文件名
        $filename = "$dirpath/$name";                                       //文件路径名
        $srcpath = "$datepath/$name";                                       //生成相对路径

        //保存图片,并输出结果
        if (file_put_contents($filename, $data)) {
            return [$filename,$srcpath];
        } else {
            return [null,null];
        }
    }

    /**
     * 以API返回形式输出
     * @param int $code
     * @param string $message
     * @param null $data
     */
    static public function sentApiResult($code=0,$message="",$data=null){
        //设置文件头(为了兼容AjaxFileUpload不能设置文件头)
        //header('Content-type: application/json');

        //构建返回体
        $result = (object)array(
            "state"=>(object)array(
                "code"=>$code,
                "massage"=>$message,
            ),
            "data"=>$data
        );

        //输出内容
        exit(json_encode($result));
    }

    //region 辅助方法

    /**
     * 按照路径创建文件夹
     * @param $path
     * @return bool
     */
    static private function mkdirs($path){
        //处理相对路径
        if($path == "." || $path == "./" || empty($path))
            return true;

        //获取父路径和文件名
        $info = pathinfo($path);
        $dirname = $info['dirname'];

        //判断父路径是否存在,不存在则递归
        if(!is_dir($dirname))
            self::mkdirs($dirname);

        //检测文件夹是否存在,不存在则新建
        if(!is_dir($path))
            mkdir($path);

        //返回
        return true;
    }

    //endregion
}