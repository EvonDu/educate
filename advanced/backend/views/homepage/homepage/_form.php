<?php

use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

/* @var $this yii\web\View */
/* @var $model common\models\page\Page */
/* @var $form yii\widgets\ActiveForm */

vuelte\lib\Import::component($this,"@app/views/components/upload-img");
//vuelte\lib\Import::component($this,"@app/views/components/summernote");
vuelte\lib\Import::component($this,"@app/views/components/ueditor");
?>
<component-template>
    <div class="page-form">

        <?php ActiveElementForm::begin(["options"=>[
            "label-width" => "100px",
            "status-icon" => true,
        ]]); ?>

        <el-form-item prop="image"
                      label="<?= ActiveElementForm::getFieldLabel($model,"image")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"image")?>">
            <upload-img v-model="data.image"></upload-img>
        </el-form-item>

        <el-form-item prop="title"
                      label="<?= ActiveElementForm::getFieldLabel($model,"title")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"title")?>">
            <el-input v-model="data.title"></el-input>
        </el-form-item>

        <el-form-item prop="title_en"
                      label="<?= ActiveElementForm::getFieldLabel($model,"title_en")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"title_en")?>">
            <el-input v-model="data.title_en"></el-input>
        </el-form-item>

        <el-form-item prop="abstract"
                      label="<?= ActiveElementForm::getFieldLabel($model,"abstract")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"abstract")?>">
            <el-input v-model="data.abstract" type="textarea"></el-input>
        </el-form-item>

        <el-form-item prop="abstract_en"
                      label="<?= ActiveElementForm::getFieldLabel($model,"abstract_en")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"abstract_en")?>">
            <el-input v-model="data.abstract_en" type="textarea"></el-input>
        </el-form-item>

        <el-form-item prop="content"
                      label="<?= ActiveElementForm::getFieldLabel($model,"content")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"content")?>">
            <ueditor v-model="data.content"></ueditor>
        </el-form-item>

        <el-form-item prop="content_en"
                      label="<?= ActiveElementForm::getFieldLabel($model,"content_en")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"content_en")?>">
            <ueditor v-model="data.content_en"></ueditor>
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
                YiiFormSubmit(this.data,"Homepage");
            }
        }
    });
</script>


