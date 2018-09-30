<?php

use yii\helpers\Html;
use yii\helpers\Url;
use vuelte\widgets\ActiveElementForm;

/* @var $this yii\web\View */
/* @var $model common\models\instructor\Instructor */
/* @var $form yii\widgets\ActiveForm */

vuelte\lib\Import::component($this, '@app/views/components/summernote', ['model' => $model]);
vuelte\lib\Import::component($this, '@app/views/components/avatar', ['model' => $model]);
vuelte\lib\Import::component($this, '@app/views/components/tags', ['model' => $model]);
?>

<component-template>
    <div class="teacher-form">
        <?php ActiveElementForm::begin(["options"=>[
            "label-width" => "100px",
            "status-icon" => true,
        ]]); ?>

        <el-form-item prop="name"
                      label="<?= ActiveElementForm::getFieldLabel($model,"name")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"name")?>">
            <el-input v-model="data.name"></el-input>
        </el-form-item>

        <el-form-item prop="avatar"
                      label="<?= ActiveElementForm::getFieldLabel($model,"avatar")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"avatar")?>">
            <avatar v-model="data.avatar" path="instructor"></avatar>
        </el-form-item>

        <el-form-item prop="title"
                      label="<?= ActiveElementForm::getFieldLabel($model,"title")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"title")?>">
            <el-input v-model="data.title"></el-input>
        </el-form-item>

        <el-form-item prop="tags"
                      label="<?= ActiveElementForm::getFieldLabel($model,"tags")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"tags")?>">
            <tags v-model="data.tags"></tags>
        </el-form-item>

        <el-form-item prop="abstract"
                      label="<?= ActiveElementForm::getFieldLabel($model,"abstract")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"abstract")?>">
            <summernote v-model="data.abstract"></summernote>
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
        },
        methods: {
            submit: function (event) {
                YiiFormSubmit(this.data, "Instructor");
            },
        }
    });
</script>


