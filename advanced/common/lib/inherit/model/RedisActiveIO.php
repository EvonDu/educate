<?php
namespace common\lib\inherit\model;

use PHPUnit\Framework\Error\Error;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * Auth controller
 * 这个控制器基类，只为了实现授权认证部分。
 * 使用方法：
 *      1、继承这个控制器类
 *      2、确保behaviors方法不被重写
 *      3、开启认证：$enableAccess = true；
 * 事项原理：
 *      其会根据当前访问把，把访问控制器和方法，设置到Yii的access过滤器的rules。
 *      其会判断当前用户是否具有：控制器/方法 的权限，如果没有则不能访问。
 *
 */
class RedisActiveIO
{
    /**
     * 读取Redis的缓存
     * @param $class
     * @param $key
     * @param $hashKey
     * @return array|null
     */
    public static function getOne($key, $hashKey, $class){
        if(Yii::$app->redis->exists($key) && Yii::$app->redis->type($key) == "hash" && Yii::$app->redis->hexists($key,$hashKey))
        {
            $value = Yii::$app->redis->hget($key,$hashKey);
            $data = (array)json_decode($value);
            $result = new $class($data);
            $result->setIsNewRecord(false); //设置为非新对象
            return $result;
        }
        else{
            return null;
        }
    }

    /**
     * 读取Redis的缓存
     * @param $class
     * @param $key
     * @param $hashKey
     * @return array|null
     */
    public static function getList($key, $hashKey, $class){
        if(Yii::$app->redis->exists($key) && Yii::$app->redis->type($key) == "hash" && Yii::$app->redis->hexists($key,$hashKey))
        {
            $value = Yii::$app->redis->hget($key,$hashKey);
            $data = (array)json_decode($value);
            $result = array();
            //数组处理
            if(is_array($data) && !empty($data)){
                foreach ($data as $key=>$value){
                    $model = new $class($value);
                    $model->setIsNewRecord(false); //设置为非新对象
                    $result[] = $model;
                }
            }
            return $result;
        }
        else{
            return null;
        }
    }

    /**
     * 设置Redis的缓存
     * @param $key
     * @param $hashKey
     * @param $data
     */
    public static function setData($key, $hashKey, $data){
        $data = ArrayHelper::toArray($data);
        $value = json_encode($data);
        Yii::$app->redis->hset($key,$hashKey,$value);
    }

    /**
     * 安全删除Redis的Key
     * @param $key
     */
    public static function deleteKey($key){
        //如果存在于Redis，则删除
        if(Yii::$app->redis->exists($key) && Yii::$app->redis->type($key) == "hash") {
            Yii::$app->redis->del($key);
        }
    }

    /**
     * 安全删除Redis的HashKey
     * @param $key
     * @param $hashKey
     */
    public static function deleteHashKey($key, $hashKey){
        //如果存在于Redis，则删除
        if(Yii::$app->redis->exists($key) && Yii::$app->redis->type($key) == "hash" && Yii::$app->redis->hexists($key,$hashKey)){
            Yii::$app->redis->hdel($key,$hashKey);
        }
    }
}
