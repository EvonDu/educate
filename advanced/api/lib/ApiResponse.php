<?php
namespace api\lib;

/**
 * Class ApiResponse
 * @package api\lib
 */
class ApiResponse{
    const MODE_JSON = "JSON";
    const MODE_DEBUG = "DEBUG";

    static $defaultMode = self::MODE_JSON;

    /**
     * @param null $mode
     * @return \Closure
     */
    static public function beforeSend($mode=null){
        $mode = $mode ? $mode : self::$defaultMode;
        switch ($mode){
            case self::MODE_DEBUG:
                $func = "responseDebug";
                break;
            default:
                $func = "responseJson";
        }
        return function ($event) use ($func){
            self::$func($event);
        };
    }

    /**
     * @param $event
     */
    static private function responseJson($event){
        //获取设置response
        $response = $event->sender;
        $response->format = \yii\web\Response::FORMAT_JSON;
        //处理返回信息
        if ($response->isSuccessful) {
            $code = 0;
            $message = "Success";
            $data = $response->data;
        }
        else {
            $code = $response->statusCode;
            $message = isset($response->data["message"])?$response->data["message"]:"";
            $data = null;
        }
        //自定义返回结构
        $response->statusCode = 200;
        $response->data = [
            'state' =>  [
                'code' => $code,
                'message' => $message,
            ],
            'data' => $data,
        ];
    }

    /**
     * @param $event
     */
    static private function responseDebug($event){
        //获取设置response
        $response = $event->sender;

        //处理
        $data = $response->data;
        var_dump($data);
        die;
    }
}