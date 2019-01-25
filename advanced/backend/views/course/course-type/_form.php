<?php

use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

/* @var $this yii\web\View */
/* @var $model common\models\course\CourseType */
/* @var $form yii\widgets\ActiveForm */
?>
<component-template>
    <div class="course-type-form">

        <?php ActiveElementForm::begin(["options"=>[
            "label-width" => "120px",
            "status-icon" => true,
        ]]); ?>

        <el-form-item prop="name"
                      label="<?= ActiveElementForm::getFieldLabel($model,"name")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"name")?>">
            <el-input v-model="data.name"></el-input>
        </el-form-item>

        <el-form-item prop="name_en"
                      label="<?= ActiveElementForm::getFieldLabel($model,"name_en")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"name_en")?>">
            <el-input v-model="data.name_en"></el-input>
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
        methods: {
            submit: function (event) {
                YiiFormSubmit(this.data, "CourseType");
            }
        }
    });
</script>


