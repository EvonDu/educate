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