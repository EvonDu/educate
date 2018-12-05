<?php

use yii\helpers\Url;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\task\TaskSubmit */

$this->title = '学生作业';
$this->params['small'] = 'List';
$this->params['breadcrumbs'][] = ['label' => '课程作业', 'url' => ['task/task/index']];
$this->params['breadcrumbs'][] = $this->title;

vuelte\lib\Import::value($this, $list, "list");
?>

<div id="app">
    <lte-row>
        <lte-col col="12">
            <lte-box title="列表" icon="fa fa-list">
                <!-- 筛选 -->
                <el-form :inline="true">
                    <el-form-item label="学生">
                        <el-input v-model="input.name" placeholder="学生"></el-input>
                    </el-form-item>
                    <el-form-item label="状态">
                        <el-select v-model="input.status" placeholder="请选择">
                            <el-option label="未批改" :value="1"></el-option>
                            <el-option label="已批改" :value="2"></el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary">查询</el-button>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="default" @click="onClear()">清空</el-button>
                    </el-form-item>
                </el-form>
                <!-- 列表 -->
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th>状态</th>
                        <th>学生</th>
                        <th>提交时间</th>
                        <th>回复时间</th>
                        <th>操作</th>
                    </tr>
                    <tr v-for="item in list" v-if="item.userName.indexOf(input.name) != -1 && (input.status == null || input.status == item.status)">
                        <td>
                            <span class="label label-success" v-if="item.status == 2">已批改</span>
                            <span class="label label-danger" v-else>未批改</span>
                        </td>
                        <td>{{item.userName}}</td>
                        <td>{{item.submitTime}}</td>
                        <td>{{item.replyTime}}</td>
                        <td><span class="label label-info" @click="onReply(item.id)">回复</span></td>
                    </tr>
                    </tbody>
                </table>
            </lte-box>
        </lte-col>
    </lte-row>
</div>

<script>
    new Vue({
        el:'#app',
        data:{
            list:list,
            input:{
                name:"",
                status:null,
            },
        },
        methods:{
            onReply : function(id){
                var url = "<?=Url::to(["reply","id"=>""],true)?>" + id;
                window.location.href = url;
            },
            onClear : function(){
                this.input.name = "";
                this.input.status = null;
            }
        }
    })
</script>
