<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\admin\ChangePasswordForm */

use yii\helpers\Url;
use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

$this->title = '用户注册';
$this->params['small'] = 'Sign Up';
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

vuelte\lib\Import::value($this, $model, "data");
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
            <lte-box title="注册用户" icon="fa fa-user-plus">

                <?php $form = ActiveElementForm::begin(["options"=>[
                    "label-width" => "100px",
                    "status-icon" => true,
                ]]); ?>

                <?= $form->field($model, 'username')->el_input(['v-model' => 'data.username', 'type' => 'input']) ?>

                <?= $form->field($model, 'email')->el_input(['v-model' => 'data.email', 'type' => 'input']) ?>

                <?= $form->field($model, 'password')->el_input(['v-model' => 'data.password', 'type' => 'password']) ?>

                <el-form-item>
                    <?= Html::tag("lte-btn","<i class='glyphicon glyphicon-floppy-disk'></i> 注册",["type" => "info", "@click" => "submit"]) ?>
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
            data:data
        },
        methods:{
            submit:function(event){
                YiiFormSubmit(this.data,"<?= $model->formName()?>");
            }
        }
    })
</script>