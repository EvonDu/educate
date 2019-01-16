<?php
namespace common\lib\base;

use yii\base\Exception;

class Http{
    const CONTENTTYPE_JSON = "Content-type: application/json;";
    const CONTENTTYPE_URLENCODE = "Content-type: application/x-www-form-urlencoded;";

    private $curl;

    public function __construct(){
        $this->curl = curl_init();
        curl_setopt($this->curl,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($this->curl,CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($this->curl, CURLOPT_HEADER, FALSE);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, TRUE);
    }

    /**
     * 执行CURL，子函数
     * @return mixed
     * @throws Exception
     */
    private function run(){
        //调用接口,并判断设置返回值
        $data = curl_exec($this->curl);

        //判断返回
        if($data){
            return $data;
        }
        else{
            $error = curl_errno($this->curl);
            throw new Exception($error);
        }
    }

    /**
     * 执行GET请求
     * @param $url
     * @return mixed
     */
    public function get($url){
        //设置参数
        curl_setopt($this->curl,CURLOPT_URL, $url);
        //调用接口
        return $this->run();
    }

    /**
     * 执行POST请求
     * @param $url
     * @param $data
     * @return mixed
     */
    public function post($url,$data){
        //设置参数
        curl_setopt($this->curl,CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_POST, TRUE);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
        //调用接口
        return $this->run();
    }

    /**
     * 关闭CURL
     */
    public function close(){
        curl_close($this->curl);
    }

    /**
     * 设置请求的头信息，参数为非key-value形式为直接的字符串数组
     * @param array $header
     */
    public function setHeader(array $header){
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $header);
    }

    /**
     * 设置请求的ContentType
     * @param $type
     */
    public function setContentType($type){
        switch ($type){
            case self::CONTENTTYPE_JSON:{
                $this->setHeader([self::CONTENTTYPE_JSON]);
                break;
            }
            default:{
                $this->setHeader([self::CONTENTTYPE_URLENCODE]);
            }
        }
    }

    /**
     * 获取响应报文的头信息
     * @return mixed
     */
    public function getResponseHeader(){
        return curl_getinfo($this->curl);
    }
}