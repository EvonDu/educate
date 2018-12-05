<?php

use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

/* @var $this yii\web\View */
/* @var $model common\models\task\TaskSubmit */
/* @var $form yii\widgets\ActiveForm */
?>
<component-template>
    <div class="task-submit-form">

        <?php ActiveElementForm::begin(["options"=>[
            "label-width" => "100px",
            "status-icon" => true,
        ]]); ?>

        <el-form-item prop="task_id"
                      label="<?= ActiveElementForm::getFieldLabel($model,"task_id")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"task_id")?>">
            <el-input v-model="data.task_id"></el-input>
        </el-form-item> 

        <el-form-item prop="user_id"
                      label="<?= ActiveElementForm::getFieldLabel($model,"user_id")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"user_id")?>">
            <el-input v-model="data.user_id"></el-input>
        </el-form-item> 

        <el-form-item prop="submit_content"
                      label="<?= ActiveElementForm::getFieldLabel($model,"submit_content")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"submit_content")?>">
            <el-input v-model="data.submit_content" type="textarea" rows="6"></el-input>
        </el-form-item> 

        <el-form-item prop="submit_file"
                      label="<?= ActiveElementForm::getFieldLabel($model,"submit_file")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"submit_file")?>">
            <el-input v-model="data.submit_file"></el-input>
        </el-form-item> 

        <el-form-item prop="submit_audio"
                      label="<?= ActiveElementForm::getFieldLabel($model,"submit_audio")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"submit_audio")?>">
            <el-input v-model="data.submit_audio"></el-input>
        </el-form-item> 

        <el-form-item prop="reply_content"
                      label="<?= ActiveElementForm::getFieldLabel($model,"reply_content")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"reply_content")?>">
            <el-input v-model="data.reply_content" type="textarea" rows="6"></el-input>
        </el-form-item> 

        <el-form-item prop="reply_file"
                      label="<?= ActiveElementForm::getFieldLabel($model,"reply_file")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"reply_file")?>"
                      v-if="date.type!=0">
            <el-input v-model="data.reply_file"></el-input>
        </el-form-item> 

        <el-form-item prop="reply_audio"
                      label="<?= ActiveElementForm::getFieldLabel($model,"reply_audio")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"reply_audio")?>"
                      v-if="date.type!=0">
            <el-input v-model="data.reply_audio"></el-input>
        </el-form-item> 

        <el-form-item prop="status"
                      label="<?= ActiveElementForm::getFieldLabel($model,"status")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"status")?>">
            <el-input v-model="data.status"></el-input>
        </el-form-item> 

        <el-form-item prop="submit_at"
                      label="<?= ActiveElementForm::getFieldLabel($model,"submit_at")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"submit_at")?>">
            <el-input v-model="data.submit_at"></el-input>
        </el-form-item> 

        <el-form-item prop="reply_at"
                      label="<?= ActiveElementForm::getFieldLabel($model,"reply_at")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"reply_at")?>">
            <el-input v-model="data.reply_at"></el-input>
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
                YiiFormSubmit(this.data, "TaskSubmit");
            }
        }
    });
</script>


