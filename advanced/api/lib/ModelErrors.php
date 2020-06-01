<?php
namespace api\lib;

/**
 * Class ModelErrors
 * @package api\lib
 */
class ModelErrors{
    /**
     * @param $model
     * @return null
     */
    static public function getError($model){
        $error = null;
        foreach ($model->firstErrors as $key=>$item){
            $error = $item;
            break;
        }
        return $error;
    }

    /**
     * @param $model
     * @return null|string
     */
    static public function getFiledError($model){
        $error = null;
        foreach ($model->firstErrors as $key=>$item){
            $error = "$key : $item";
            break;
        }
        return $error;
    }
}