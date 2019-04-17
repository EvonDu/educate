<?php
require(__DIR__."/../../vendor/autoload.php");
//获取当前访问地址
$site_url = $_SERVER["SERVER_PORT"] == "80" ?
    dirname($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) :
    dirname($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"]);
define("API_HOST",$site_url);
//输出Swagger文档
$openapi = \OpenApi\scan(__DIR__."/../modules");
header('Content-Type: application/x-yaml');
echo $openapi->toYaml();