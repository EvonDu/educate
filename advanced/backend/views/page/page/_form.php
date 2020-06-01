<?php

use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

/* @var $this yii\web\View */
/* @var $model common\models\page\Page */
/* @var $form yii\widgets\ActiveForm */

vuelte\lib\Import::component($this,"@app/views/components/ueditor");
?>
<component-template>
    <div class="page-form">

        <?php ActiveElementForm::begin(["options"=>[
            //"label-width" => "100px",
            "status-icon" => true,
        ]]); ?>

        <h4><b><?= ActiveElementForm::getFieldLabel($model,"content")?>：</b></h4>
        <el-form-item prop="content"
                      error="<?= ActiveElementForm::getFieldError($model,"content")?>">
            <ueditor v-model="data.content"></ueditor>
        </el-form-item>

        <h4><b><?= ActiveElementForm::getFieldLabel($model,"content_en")?>：</b></h4>
        <el-form-item prop="content_en"
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
            data:{ type: Object, default: function(){ return {}; }}
        },
        methods: {
            submit: function (event) {
                YiiFormSubmit(this.data, "Page");
            }
        }
    });
</script>


