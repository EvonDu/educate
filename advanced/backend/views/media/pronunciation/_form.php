<?php

use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

/* @var $this yii\web\View */
/* @var $model common\models\media\Pronunciation */
/* @var $form yii\widgets\ActiveForm */

vuelte\lib\Import::component($this, '@app/views/components/upload-video.php', ['model' => $model]);
?>
<component-template>
    <div class="pronunciation-form">

        <?php ActiveElementForm::begin(["options"=>[
            "label-width" => "100px",
            "status-icon" => true,
        ]]); ?>

        <el-form-item prop="word"
                      label="<?= ActiveElementForm::getFieldLabel($model,"word")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"word")?>">
            <el-input v-model="data.word"></el-input>
        </el-form-item> 

        <el-form-item prop="audio"
                      label="<?= ActiveElementForm::getFieldLabel($model,"audio")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"audio")?>">
            <upload-video v-model="data.audio"></upload-video>
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
                YiiFormSubmit(this.data, "Pronunciation");
            }
        }
    });
</script>


