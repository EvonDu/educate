<?php

use yii\helpers\Url;
use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

/* @var $this yii\web\View */
/* @var $items array */

$this->title = "积分配置";
$this->params['small'] = 'Setting';
$this->params['breadcrumbs'][] = $this->title;

vuelte\lib\Import::value($this, $items, "items");
vuelte\lib\Import::component($this,'@app/views/components/avatar');
?>
<div id="app">
    <lte-row>
        <lte-col col="12">
            <lte-box title="设置" icon="fa fa-edit">

                <?php ActiveElementForm::begin(["options"=>[
                    "label-width" => "120px",
                    "status-icon" => true,
                ]]); ?>

                <el-form-item label="邀请注册(固定)">
                    <el-input-number v-model="items.point_fix_register"></el-input-number>
                </el-form-item>

                <el-form-item label="被邀人购买(比例)">
                    <el-input-number v-model="items.point_percent_invitee_buy"></el-input-number>
                </el-form-item>

                <el-form-item label="购买课程(比例)">
                    <el-input-number v-model="items.point_percent_buy"></el-input-number>
                </el-form-item>

                <el-form-item label="完成课程(比例)">
                    <el-input-number v-model="items.point_percent_complete"></el-input-number>
                </el-form-item>

                <el-form-item>
                    <lte-btn type="info" @click="submit"><i class='glyphicon glyphicon-floppy-disk'></i> 保存</lte-btn>
                </el-form-item>

                <?php ActiveElementForm::end(); ?>

            </lte-box>
        </lte-col>
    </lte-row>
</div>

<script>
    new Vue({
        el:'#app',
        data:{
            items:items,
        },
        methods:{
            submit:function(event){
                YiiFormSubmit(this.items);
            },
        }
    })
</script>