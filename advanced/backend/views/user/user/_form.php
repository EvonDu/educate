<?php

use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

/* @var $this yii\web\View */
/* @var $model common\models\user\User */
/* @var $form yii\widgets\ActiveForm */

vuelte\lib\Import::component($this,'@app/views/components/avatar');
?>
<component-template>

    <div class="admin-form">

        <?php ActiveElementForm::begin(["options"=>[
            "label-width" => "100px",
            "status-icon" => true,
        ]]); ?>

        <el-form-item prop="avatar"
                      label="<?= ActiveElementForm::getFieldLabel($model,"avatar")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"avatar")?>">
            <avatar v-model="data.avatar"></avatar>
        </el-form-item>

        <el-form-item prop="email"
                      label="<?= ActiveElementForm::getFieldLabel($model,"email")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"email")?>">
            <el-input v-model="data.email"></el-input>
        </el-form-item>

        <el-form-item prop="nickname"
                      label="<?= ActiveElementForm::getFieldLabel($model,"nickname")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"nickname")?>">
            <el-input v-model="data.nickname"></el-input>
        </el-form-item>

        <el-form-item prop="sex"
                      label="<?= ActiveElementForm::getFieldLabel($model,"sex")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"sex")?>">
            <el-input v-model="data.sex"></el-input>
        </el-form-item>

        <el-form-item prop="phone"
                      label="<?= ActiveElementForm::getFieldLabel($model,"phone")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"phone")?>">
            <el-input v-model="data.phone"></el-input>
        </el-form-item>

        <el-form-item prop="country"
                      label="<?= ActiveElementForm::getFieldLabel($model,"country")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"country")?>">
            <el-input v-model="data.country"></el-input>
        </el-form-item>

        <el-form-item prop="city"
                      label="<?= ActiveElementForm::getFieldLabel($model,"city")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"city")?>">
            <el-input v-model="data.city"></el-input>
        </el-form-item>

        <el-form-item prop="adderss_1"
                      label="<?= ActiveElementForm::getFieldLabel($model,"adderss_1")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"adderss_1")?>">
            <el-input v-model="data.adderss_1"></el-input>
        </el-form-item>

        <el-form-item prop="adderss_2"
                      label="<?= ActiveElementForm::getFieldLabel($model,"adderss_2")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"adderss_2")?>">
            <el-input v-model="data.adderss_2"></el-input>
        </el-form-item>

        <el-form-item>
            <lte-btn type="info" @click="submit"><i class="glyphicon glyphicon-floppy-disk"></i> 保存</lte-btn>
        </el-form-item>

        <?php ActiveElementForm::end(); ?>

    </div>
</component-template>

<script>
    Vue.component('model-form', {
        template: '{{component-template}}',
        props:{
            'data':{ type: Object, default: function(){ return {}; }}
        },
        methods: {
            submit: function (event) {
                YiiFormSubmit(this.data, "User");
            }
        }
    });
</script>


