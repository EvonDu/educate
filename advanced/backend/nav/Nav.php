<?php
namespace backend\nav;

use yii\helpers\Url;

class Nav
{
    static function getNav()
    {
        $menuItems = array(
            array(
                'title' => '功能列表',
                'header' => true
            ),
            array(
                'url' => Url::to(['site/home']),
                'title' => "仪表盘",
                'icon' => 'fa fa-dashboard',
                'auth' => '',
            ),
            array(
                'url' => '#',
                'title' => "管理员",
                'icon' => 'fa fa-address-card',
                'auth' => '',
                'tags' => array(array('content' => 'system','class'=>'bg-teal'),),
                'nodes' => array(
                    array('title' => "系统用户", 'url' => Url::to(['user/admin/index'])),
                    //array('title' => "角色管理", 'url' => Url::to(['user/role/index'])),
                    //array('title' => "权限管理", 'url' => Url::to(['user/auth/index'])),
                )
            ),
            array(
                'url' => '#',
                'title' => "用户管理",
                'icon' => 'fa fa-users',
                'auth' => '',
                'nodes' => array(
                    array('title' => "用户管理", 'url' => Url::to(['user/user/index'])),
                    array('title' => "用户收藏", 'url' => Url::to(['user/user-favorite/index']),'tags'=>array(array('content' => '暂时','class'=>'bg-teal'))),
                    array('title' => "用户课程", 'url' => Url::to(['user/user-course/index']),'tags'=>array(array('content' => '暂时','class'=>'bg-teal'))),
                )
            ),
            array(
                'url' => '#',
                'title' => "课程管理",
                'icon' => 'fa fa-book',
                'auth' => '',
                'nodes' => array(
                    array('title' => "课程列表", 'url' => Url::to(['course/course/index'])),
                    array('title' => "首推课程", 'url' => Url::to(['course/course/recommend'])),
                    array('title' => "课程类型", 'url' => Url::to(['course/course-type/index'])),
                )
            ),
            array(
                'url' => '#',
                'title' => "资料管理",
                'icon' => 'fa fa-address-book',
                'auth' => '',
                'nodes' => array(
                    array('title' => "教师管理", 'url' => Url::to(['instructor/instructor/index'])),
                )
            ),
            array(
                'url' => '#',
                'title' => "媒体库",
                'icon' => 'fa fa-youtube-play',
                'auth' => '',
                'nodes' => array(
                    array('title' => "单词发音", 'url' => Url::to(['media/pronunciation/index'])),
                )
            ),
            //相关接口
            array(
                'title' => '系统接口',
                'header' => true
            ),
            array(
                'url' => dirname(dirname(Url::home(true)))."/api/web/swagger",
                'title' => "接口文档",
                'icon' => 'fa fa-file-text-o',
                'auth' => '',
                'tags' => array(array('content' => 'swagger','class'=>'bg-green'),),
            ),
        );

        return $menuItems;
    }
}
?>