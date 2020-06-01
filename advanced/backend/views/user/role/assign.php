<?php

use yii\helpers\Url;
use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;


/* @var $this yii\web\View */
/* @var $model common\models\auth\AuthItem */

$this->title = '分配权限';
$this->params['small'] = 'Authority';
$this->params['breadcrumbs'][] = ['label' => '角色管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

vuelte\lib\Import::value($this, $model, "data")
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
        <lte-col col="9">
            <lte-box title="分配权限" icon="fa fa-lock">

                <?php $form = ActiveElementForm::begin(["options"=>[
                    "label-width" => "100px",
                    "status-icon" => true,
                ]]); ?>

                <el-form-item prop="auths"
                              label="<?= ActiveElementForm::getFieldLabel($model,"auths")?>"
                              error="<?= ActiveElementForm::getFieldError($model,"auths")?>">
                    <el-checkbox-group v-model="data.auths">
                        <el-checkbox v-for="(item,key) in items" :label="key" :key="key">{{item}}</el-checkbox>
                    </el-checkbox-group>
                </el-form-item>

                <el-form-item>
                    <?= Html::tag("lte-btn","<i class='glyphicon glyphicon-floppy-disk'></i> 保存",["type" => "info", "@click" => "submit"]) ?>
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
            data:data,
            items:<?=json_encode($model->list)?>,
        },
        methods:{
            submit:function(event){
                YiiFormSubmit(this.data,"<?= $model->formName()?>");
            },
        }
    })
</script>