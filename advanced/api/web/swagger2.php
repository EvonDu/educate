<?php
require(__DIR__."/../../vendor/autoload.php");
//获取当前访问地址
define("API_HOST",dirname($_SERVER["PHP_SELF"]));
//输出Swagger文档
$openapi = \OpenApi\scan(__DIR__."/../modules/v2");
header('Content-Type: application/x-yaml');
echo $openapi->toYaml();