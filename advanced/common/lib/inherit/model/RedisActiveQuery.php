<?php
namespace common\lib\inherit\model;

use PHPUnit\Framework\Error\Error;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\base\InvalidArgumentException;

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
class RedisActiveQuery extends \yii\db\ActiveQuery
{
    public function all($db = null){
        //获取sql语句
        $sql = $this->createCommand()->getRawSql();
        $class = $this->modelClass;
        $hash = md5($sql);
        $key = Yii::$app->id."::".$class."::All";

        $result = RedisActiveIO::getList($key,$hash,$class);
        if(empty($result)){
            $result = parent::all($db);
            RedisActiveIO::setData($key,$hash,$result);
        }
        return $result;
    }

    public function one($db = null){
        //尝试使用主键的方式进行查询
        $keyResult = $this->key($db);
        if($keyResult)
            return $keyResult;

        //获取sql语句
        $sql = $this->createCommand()->getRawSql();
        $class = $this->modelClass;
        $hash = md5($sql);
        $key = Yii::$app->id."::".$class."::One";

        //查询Redis
        $result = RedisActiveIO::getOne($key,$hash,$class);
        if(empty($result)){
            $result = parent::one($db);
            RedisActiveIO::setData($key,$hash,$result);
        }
        return $result;
    }

    private function key($db = null){
        $class = $this->modelClass;
        $primaryKey = $class::primaryKey();
        if(ArrayHelper::isAssociative($this->where) && isset($primaryKey[0]) && isset($this->where[$primaryKey[0]])){
            //获取信息
            $hash = $this->where[$primaryKey[0]];
            $key = Yii::$app->id."::".$class."::Key";

            //查询Redis
            $result = RedisActiveIO::getOne($key,$hash,$class);
            if(empty($result)){
                $result = parent::one($db);
                RedisActiveIO::setData($key,$hash,$result);
            }
            return $result;
        }
        else{
            return null;
        }
    }
}
