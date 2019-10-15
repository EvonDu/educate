<?php

use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

/* @var $this yii\web\View */
/* @var $courses array */
/* @var $model common\models\preferential\Preferential */
/* @var $form yii\widgets\ActiveForm */

vuelte\lib\Import::value($this, $courses, 'courses');
vuelte\lib\Import::component($this, '@app/views/components/input-preferential-items');
?>
<component-template>
    <div class="preferential-form">

        <?php ActiveElementForm::begin(["options"=>[
            "label-width" => "100px",
            "status-icon" => true,
        ]]); ?>

        <el-form-item prop="name"
                      label="<?= ActiveElementForm::getFieldLabel($model,"name")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"name")?>">
            <el-input v-model="data.name"></el-input>
        </el-form-item> 

        <el-form-item prop="remarks"
                      label="<?= ActiveElementForm::getFieldLabel($model,"remarks")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"remarks")?>">
            <el-input v-model="data.remarks" type="textarea" rows="6"></el-input>
        </el-form-item> 

        <el-form-item prop="start_time"
                      label="<?= ActiveElementForm::getFieldLabel($model,"start_time")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"start_time")?>">
            <el-date-picker v-model="data.start_time" type="datetime" value-format="yyyy-MM-dd hh:mm:ss" default-time="00:00:00" placeholder="选择日期时间"></el-date-picker>
        </el-form-item> 

        <el-form-item prop="end_time"
                      label="<?= ActiveElementForm::getFieldLabel($model,"end_time")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"end_time")?>">
            <el-date-picker v-model="data.end_time" type="datetime" value-format="yyyy-MM-dd hh:mm:ss" default-time="23:59:59" placeholder="选择日期时间"></el-date-picker>
        </el-form-item>

        <el-form-item prop="items"
                      label="<?= ActiveElementForm::getFieldLabel($model,"items")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"items")?>">
            <input-preferential-items :courses="courses" v-model="data.items"></input-preferential-items>
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
            data:{ type: Object, default: function(){ return {}; }}
        },
        data:function(){
            return {
                courses:courses
            }
        },
        methods: {
            submit: function (event) {
                YiiFormSubmit(this.data, "Preferential");
            }
        }
    });
</script>


