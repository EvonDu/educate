<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\admin\ChangePasswordForm */

use yii\helpers\Url;
use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

$this->title = '修改密码';
$this->params['small'] = 'Change Password';
$this->params['breadcrumbs'][] = $this->title;

vuelte\lib\Import::value($this, $model, "data");
?>
<div id="app">
    <lte-row>
        <lte-col col="3">
            <lte-box title="选项" icon="fa fa-edit">
                <?= Html::tag("lte-btn","<i class='glyphicon glyphicon-user'></i> 用户",[
                    "href"=>Url::to(["view",'id'=>Yii::$app->user->id]),
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
            <lte-box title="修改密码" icon="fa fa-lock">

                <?php $form = ActiveElementForm::begin(["options"=>[
                    "label-width" => "100px",
                    "status-icon" => true,
                ]]); ?>

                <?= $form->field($model, 'password')->el_input(['v-model' => 'data.password', 'type' => 'password']) ?>

                <?= $form->field($model, 'password_new')->el_input(['v-model' => 'data.password_new', 'type' => 'password']) ?>

                <?= $form->field($model, 'password_confirm')->el_input(['v-model' => 'data.password_confirm', 'type' => 'password']) ?>

                <el-form-item>
                    <?= Html::tag("lte-btn","<i class='glyphicon glyphicon-ok-circle'></i> 修改",["type" => "info", "@click" => "submit"]) ?>
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