<?php

use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

/* @var $this yii\web\View */
/* @var $model common\models\task\Task */
/* @var $form yii\widgets\ActiveForm */
vuelte\lib\Import::component($this, '@app/views/components/ueditor', ['model' => $model]);
vuelte\lib\Import::component($this, '@app/views/components/upload-file', ['model' => $model]);
?>
<component-template>
    <div class="task-form">

        <?php ActiveElementForm::begin(["options"=>[
            "label-width" => "100px",
            "status-icon" => true,
        ]]); ?>

        <el-form-item prop="type"
                      label="<?= ActiveElementForm::getFieldLabel($model,"type")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"type")?>">
            <el-select v-model="data.type" placeholder="请选择">
                <?php foreach (\common\models\task\Task::getTypeMap() as $key=>$value):?>
                <el-option label="<?=$value?>" :value="<?=$key?>"><?=$value?></el-option>
                <?php endforeach;?>
            </el-select>
        </el-form-item>

        <el-form-item prop="title"
                      label="<?= ActiveElementForm::getFieldLabel($model,"title")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"title")?>">
            <el-input v-model="data.title"></el-input>
        </el-form-item> 

        <el-form-item prop="content"
                      label="<?= ActiveElementForm::getFieldLabel($model,"content")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"content")?>">
            <ueditor v-model="data.content"></ueditor>
        </el-form-item> 

        <el-form-item prop="file"
                      v-if="data.type == 3"
                      label="<?= ActiveElementForm::getFieldLabel($model,"file")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"file")?>">
            <upload-file v-model="data.file" path="task"></upload-file>
        </el-form-item> 

        <el-form-item prop="audio"
                      v-if="data.type != 0"
                      label="<?= ActiveElementForm::getFieldLabel($model,"audio")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"audio")?>">
            <upload-file v-model="data.audio" path="task"></upload-file>
        </el-form-item>

        <el-form-item prop="finish_at"
                      label="<?= ActiveElementForm::getFieldLabel($model,"finish_at")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"finish_at")?>">
            <el-date-picker
                    v-model="data.finish_at"
                    type="date"
                    placeholder="选择日期"
                    value-format="timestamp">
            </el-date-picker>
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
        created:function(){
            this.data.finish_at = this.data.finish_at * 1000;
        },
        methods: {
            submit: function (event) {
                var request = JSON.parse(JSON.stringify(this.data));
                request.finish_at = request.finish_at/1000;
                YiiFormSubmit(request, "Task");
            }
        }
    });
</script>


