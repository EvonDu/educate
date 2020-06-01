<?php
namespace api\lib;

use Yii;
use yii\web\BadRequestHttpException;

/**
 * Class ApiResponse
 * @package api\lib
 */
class ApiRequest{
    /**
     * 检测GET参数是否存在
     * @param $list
     * @throws BadRequestHttpException
     */
    static public function checkGet($list){
        foreach ($list as $item){
            $value = Yii::$app->request->get($item,null);
            if($value === null)
                throw new BadRequestHttpException("missing parameter : $item");
        }
    }

    /**
     * 检测POST参数是否存在
     * @param $list
     * @throws BadRequestHttpException
     */
    static public function checkPost($list){
        foreach ($list as $item){
            $value = Yii::$app->request->post($item,null);
            if($value === null)
                throw new BadRequestHttpException("missing parameter : $item");
        }
    }

    /**
     * 获取JSON数据(返回对象)
     * @param array $requests
     * @return mixed
     * @throws BadRequestHttpException
     */
    static public function getJsonParams(array $requests=[]){
        //获取参数
        $request = file_get_contents("php://input");
        $params = json_decode($request);

        //检测参数
        foreach ($requests as $request){
            if(!isset($params->$request))
                throw new BadRequestHttpException("missing parameter [$request]");
        }

        //返回参数
        return $params;
    }

    /**
     * 获取GET参数(返回数组顺序与$list一致)
     * @param $list
     * @return array
     * @throws BadRequestHttpException
     */
    static public function getGetParams($list, $allowNull = false){
        $params = [];
        foreach ($list as $item){
            $value = Yii::$app->request->get($item,null);
            if(!$allowNull && $value === null)
                throw new BadRequestHttpException("missing parameter : $item");
            else
                $params[] = $value;
        }
        return $params;
    }

    /**
     * 获取POST参数(返回数组顺序与$list一致)
     * @param $list
     * @return array
     * @throws BadRequestHttpException
     */
    static public function getPostParams($list, $allowNull = false){
        $params = [];
        foreach ($list as $item){
            $value = Yii::$app->request->post($item,null);
            if(!$allowNull && $value === null)
                throw new BadRequestHttpException("missing parameter : $item");
            else
                $params[] = $value;
        }
        return $params;
    }

    /**
     * 检测是否为Https请求
     * @return bool
     */
    static public function isHttps(){
        if ( !empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
            return true;
        } elseif ( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
            return true;
        } elseif ( !empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
            return true;
        }
        return false;
    }

    /**
     * 注入分页参数
     * @param $dataProvider
     * @return array
     */
    static public function injectionPage($dataProvider){
        //设置参数
        if($page = Yii::$app->request->get("page",null))
            $dataProvider->pagination->setPage($page - 1);
        if($pageSize = Yii::$app->request->get("pageSize",null))
            $dataProvider->pagination->setPageSize($pageSize);

        //分页数据
        $page = $dataProvider->pagination->page + 1;
        $totalCount = $dataProvider->getTotalCount();
        $pageSize = $dataProvider->pagination->pageSize;
        $pageCount = ceil($totalCount/$pageSize);

        //返回分页信息
        return [
            "page" => $page,
            "pageSize" => $pageSize,
            "pageCount" => $pageCount,
            "totalCount" => $totalCount,
        ];
    }
}