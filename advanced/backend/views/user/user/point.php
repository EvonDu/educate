<?php

use yii\helpers\Url;
use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

/* @var $this yii\web\View */
/* @var $history array */
/* @var $activities array */
/* @var $model common\models\user\UserPoint */

$this->title = "用户积分";
$this->params['small'] = 'Point';
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user->nickname, 'url' => ['view', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = '用户积分';

vuelte\lib\Import::value($this, $model, "data");
vuelte\lib\Import::value($this, $activities, "activities");
vuelte\lib\Import::component($this,'@app/views/components/avatar');
?>
<div id="app">
    <lte-row>
        <lte-col col="3">
            <lte-box title="选项" icon="fa fa-edit">
                <?= Html::tag("lte-btn","<i class='glyphicon glyphicon-list'></i> 列表",[
                    "href"=>Url::to(["index"]),
                    "a"=>true,
                    "block"=>true,
                ])?>
                <?= Html::tag("lte-btn","<i class='glyphicon glyphicon-share-alt'></i> 返回",[
                    "href"=>"javascript:history.go(-1)",
                    "a"=>true,
                    "block"=>true,
                    "type"=>"warning"
                ])?>
            </lte-box>
        </lte-col>
        <lte-col col="4">
            <lte-box title="当前总积分" icon="fa fa-edit">
                <el-button type="text">当前积分： {{data.total}}</el-button>
                <el-divider></el-divider>
                <div class="admin-form">

                    <?php ActiveElementForm::begin(["options"=>[
                        "label-width" => "100px",
                        "status-icon" => true,
                    ]]); ?>

                    <el-form-item label="添加积分">
                        <el-input-number v-model="inventory" label="添加积分"></el-input-number>
                    </el-form-item>

                    <el-form-item>
                        <lte-btn type="info" @click="submit"><i class="glyphicon glyphicon-floppy-disk"></i> 提交</lte-btn>
                    </el-form-item>

                    <?php ActiveElementForm::end(); ?>

                </div>
            </lte-box>
        </lte-col>
        <lte-col col="5">
            <lte-box title="历史记录" icon="fa fa-comment-o">
                <el-timeline :reverse="reverse">
                    <el-timeline-item v-for="(activity, index) in activities" :key="index" :timestamp="activity.time">
                        <div>
                            <div>积分变动: <span style="color: #3c8dbc;font-weight: bold">{{activity.increment}}</span></div>
                            <div style="color: #999999">{{activity.remark}}</div>
                        </div>
                    </el-timeline-item>
                </el-timeline>
            </lte-box>
        </lte-col>
    </lte-row>
</div>

<script>
    new Vue({
        el:'#app',
        data:{
            data:data,
            inventory:0,
            activities: activities,
        },
        methods:{
            submit:function(event){
                YiiFormSubmit({inventory:this.inventory});
            },
        }
    })
</script>