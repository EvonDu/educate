<?php

use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

/* @var $this yii\web\View */
/* @var $model common\models\customer\CustomerForm */
/* @var $form yii\widgets\ActiveForm */
?>
<component-template>
    <div class="customer-form">

        <?php ActiveElementForm::begin(["options"=>[
            "label-width" => "100px",
            "status-icon" => true,
        ]]); ?>

        <el-form-item prop="name"
                      label="<?= ActiveElementForm::getFieldLabel($model,"name")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"name")?>">
            <el-input v-model="data.name"></el-input>
        </el-form-item>

        <el-form-item prop="quantity"
                      label="<?= ActiveElementForm::getFieldLabel($model,"quantity")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"quantity")?>">
            <el-input-number v-model="data.quantity"></el-input-number>
        </el-form-item>

        <el-form-item prop="courses"
                      label="<?= ActiveElementForm::getFieldLabel($model,"courses")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"courses")?>">
            <el-select v-model="data.courses" multiple placeholder="请选择">
                <el-option v-for="(item,key) in list" :key="key" :label="item" :value="key"></el-option>
            </el-select>
        </el-form-item>

        <el-form-item prop="course_used_at"
                      label="<?= ActiveElementForm::getFieldLabel($model,"course_used_at")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"course_used_at")?>">
            <el-date-picker v-model="data.course_used_at" type="date" placeholder="选择日期" value-format="timestamp"></el-date-picker>
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
            data:{ type: Object, default: function(){ return {}; }},
            list:{ type: Object, default: function(){ return {}; }}
        },
        methods: {
            submit: function (event) {
                //提交表单
                YiiFormSubmit(this.data, "CustomerForm");
            }
        }
    });
</script>


