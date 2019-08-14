<?php
//检查上传
if(empty($_FILES["file"]))
    exit("请上传文件");

//设置参数
$file = $_FILES["file"];
$path = __DIR__."/run/";
$filename = __DIR__."/run/upload.zip";

//保存文件
$res = move_uploaded_file($file['tmp_name'],$filename);

//删除文件

//解压缩文件
$zip = new ZipArchive();
//打开压缩文件，打开成功时返回true
if ($zip->open($filename) === true) {
    //解压文件到指定文件夹下
    $zip->extractTo($path);
    //关闭
    $zip->close();
    //输出结果
    exit("SUCCESS");
} else {
    //输出结果
    exit("ERROR");
}