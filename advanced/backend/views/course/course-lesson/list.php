<?php

use yii\helpers\Url;
use yii\helpers\Html;
use vuelte\widgets\GridView;

/* @var $this yii\web\View */
/* @var $course common\models\course\Course */

$this->title = '课程章节';
$this->params['small'] = 'List';
$this->params['breadcrumbs'][] = ['label' => '课程管理', 'url' => Url::to(["course/course"])];
$this->params['breadcrumbs'][] = ['label' => $course->name, 'url' => Url::to(["course/course/view","id"=>$course->id])];
$this->params['breadcrumbs'][] = $this->title;

vuelte\tools\VarConvert::run($this, $course, "course");
vuelte\tools\VarConvert::run($this, $lessons, "lessons");
?>
<style>
    .el-collapse-item__header{
        font-weight: 900;
    }
</style>

<div id="app">
    <lte-row>
        <lte-col col="3">
            <lte-box title="选项" icon="fa fa-edit">
                <?= Html::tag("lte-btn","<i class='glyphicon glyphicon-book'></i> 课程",[
                    "href"=>Url::to(["course/course"]),
                    "a"=>true,
                    "block"=>true,
                ])?>
                <?= Html::tag("lte-btn","<i class='glyphicon glyphicon-plus'></i> 添加",[
                    "href"=>Url::to(["create","course_id" => $course->id]),
                    "a"=>true,
                    "block"=>true,
                    "type"=>"info"
                ])?>
                <?= Html::tag("lte-btn","<i class='glyphicon glyphicon-share-alt'></i> 返回",[
                    "href"=>"javascript:history.go(-1)",
                    "a"=>true,
                    "block"=>true,
                    "type"=>"warning"
                ])?>
            </lte-box>
        </lte-col>
        <lte-col col="9">
            <lte-box title="列表" icon="fa fa-list">

                <el-collapse accordion>
                    <el-collapse-item v-for="(item,index) in lessons" :title="'第'+ item.lesson + '章：' + item.title" :name="index">
                        <el-row style="margin-bottom: 8px;padding: 0px 8px">
                            <div v-html="item.abstract"></div>
                        </el-row>
                        <el-row>
                            <el-button type="primary" size="mini" @click="view(item.id)">查看</el-button>
                            <el-button type="success" size="mini" @click="update(item.id)">编辑</el-button>
                            <el-button type="danger" size="mini" @click="remove(item.id)">删除</el-button>
                        </el-row>
                    </el-collapse-item>
                </el-collapse>

            </lte-box>
        </lte-col>
    </lte-row>
</div>

<script>
    new Vue({
        el:'#app',
        data:{
            course:course,
            lessons:lessons,
        },
        methods:{
            view:function(id){
                location.href = "<?=Url::to(["view",'id'=>''])?>"+id;
            },
            update:function(id){
                location.href = "<?=Url::to(["update",'id'=>''])?>"+id;
            },
            remove:function(id){
                if( window.confirm('确实要删除该内容吗?') ){
                    var temp_form = document.createElement("form");
                    temp_form.action = "<?=Url::to(["delete",'id'=>''])?>"+id;
                    temp_form.method = "post";
                    temp_form.style.display = "none";
                    document.body.appendChild(temp_form);
                    temp_form.submit();
                }
            }
        }
    })
</script>
