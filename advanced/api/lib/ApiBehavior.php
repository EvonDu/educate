<?php
namespace api\lib;

use Yii;
use yii\base\Event;
use yii\base\Behavior;
use yii\web\Response;
use yii\web\Controller;

/**
 * Class ApiBehavior
 * @package api\lib
 */
class ApiBehavior extends Behavior
{
    /**
     * 绑定事件
     * @return array
     */
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'logs',
        ];
    }

    /**
     * 设置Response
     * @param $event
     */
    public function logs($event){
    }
}