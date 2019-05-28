<?php

use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

/* @var $this yii\web\View */
/* @var $model common\models\course\CourseLesson */
/* @var $form yii\widgets\ActiveForm */

vuelte\lib\Import::component($this, '@app/views/components/ueditor', ['model' => $model]);
vuelte\lib\Import::component($this, '@app/views/components/summernote', ['model' => $model]);
vuelte\lib\Import::component($this, '@app/views/components/upload-video', ['model' => $model]);
?>
<component-template>
    <div class="course-lesson-form">

        <?php ActiveElementForm::begin(["options"=>[
            "label-width" => "100px",
            "status-icon" => true,
        ]]); ?>

        <el-tabs value="base">
            <el-tab-pane label="章节信息" name="base">

                <el-form-item prop="lesson"
                              label="<?= ActiveElementForm::getFieldLabel($model,"lesson")?>"
                              error="<?= ActiveElementForm::getFieldError($model,"lesson")?>">
                    <el-input v-model="data.lesson"></el-input>
                </el-form-item>

                <el-form-item prop="title"
                              label="<?= ActiveElementForm::getFieldLabel($model,"title")?>"
                              error="<?= ActiveElementForm::getFieldError($model,"title")?>">
                    <el-input v-model="data.title"></el-input>
                </el-form-item>

                <el-form-item prop="abstract"
                              label="<?= ActiveElementForm::getFieldLabel($model,"abstract")?>"
                              error="<?= ActiveElementForm::getFieldError($model,"abstract")?>">
                    <summernote v-model="data.abstract"></summernote>
                </el-form-item>

                <el-form-item prop="try"
                              label="<?= ActiveElementForm::getFieldLabel($model,"try")?>"
                              error="<?= ActiveElementForm::getFieldError($model,"try")?>">
                    <el-switch v-model="data.try" active-value="1" inactive-value="0"></el-switch>
                </el-form-item>

            </el-tab-pane>

            <el-tab-pane label="章节内容" name="content">

                <el-form-item prop="video"
                              label="<?= ActiveElementForm::getFieldLabel($model,"video")?>"
                              error="<?= ActiveElementForm::getFieldError($model,"video")?>">
                    <upload-video v-model="data.video" path="video"></upload-video>
                </el-form-item>

                <el-form-item prop="content"
                              label="<?= ActiveElementForm::getFieldLabel($model,"content")?>"
                              error="<?= ActiveElementForm::getFieldError($model,"content")?>">
                    <!--<el-input v-model="data.content" type="textarea" rows="16"></el-input>-->
                    <ueditor v-model="data.content"></ueditor>
                </el-form-item>

            </el-tab-pane>
        </el-tabs>

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
                YiiFormSubmit(this.data, "CourseLesson");
            }
        }
    });
</script>


