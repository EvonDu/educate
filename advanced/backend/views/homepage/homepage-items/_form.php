<?php

use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

/* @var $this yii\web\View */
/* @var $model common\models\homepage\HomepageItems */
/* @var $form yii\widgets\ActiveForm */

vuelte\lib\Import::component($this,"@app/views/components/upload-img");
//vuelte\lib\Import::component($this,"@app/views/components/summernote");
vuelte\lib\Import::component($this,"@app/views/components/ueditor");
?>
<component-template>
    <div class="homepage-items-form">

        <?php ActiveElementForm::begin(["options"=>[
            "label-width" => "100px",
            "status-icon" => true,
        ]]); ?>

        <el-form-item prop="order"
                      label="<?= ActiveElementForm::getFieldLabel($model,"order")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"order")?>">
            <el-input v-model="data.order"></el-input>
        </el-form-item>

        <el-form-item prop="image"
                      label="<?= ActiveElementForm::getFieldLabel($model,"image")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"image")?>">
            <upload-img v-model="data.image"></upload-img>
        </el-form-item>

        <el-form-item prop="content"
                      label="<?= ActiveElementForm::getFieldLabel($model,"content")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"content")?>">
            <ueditor v-model="data.content"></ueditor>
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
                YiiFormSubmit(this.data, "HomepageItems");
            }
        }
    });
</script>


