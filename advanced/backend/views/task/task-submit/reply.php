<?php

use yii\helpers\Url;
use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

/* @var $this yii\web\View */
/* @var $model common\models\task\TaskSubmit */

$this->title = '作业批改';
$this->params['small'] = 'Reply';
$this->params['breadcrumbs'][] = ['label' => '课程作业', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $task->title, 'url' => ['task/task-submit/list', 'id' => $task->id]];
$this->params['breadcrumbs'][] = $this->title;

vuelte\lib\Import::value($this, $model, "data");
vuelte\lib\Import::component($this,'_form', ['model' => $model]);
vuelte\lib\Import::component($this, '@app/views/components/upload-file', ['model' => $model]);
?>
<div id="app">
    <lte-row>
        <lte-col>
            <lte-box title="作业内容" icon="fa fa-file-text">
                <?php ActiveElementForm::begin(["options"=>[
                    "label-width" => "100px",
                    "status-icon" => true,
                ]]); ?>

                <el-form-item label="标题">
                    <?=$task->title?>
                </el-form-item>

                <el-form-item label="内容">
                    <?=$task->content?>
                </el-form-item>

                <?php if(!empty($task->file)):?>
                <el-form-item label="文件">
                    <a type="button" class="btn btn-primary btn-flat" href="<?=$task->file?>" target="_blank">文件下载</a>
                </el-form-item>
                <?php endif;?>

                <?php if(!empty($task->audio)):?>
                <el-form-item label="音频">
                    <a type="button" class="btn btn-primary btn-flat" href="<?=$task->audio?>" target="_blank">文件下载</a>
                </el-form-item>
                <?php endif;?>

                <el-form-item label="提交答案">
                    <?=$model->submit_content?>
                </el-form-item>

                <?php if(!empty($model->submit_file)):?>
                    <el-form-item label="提交文件">
                        <a type="button" class="btn btn-primary btn-flat" href="<?=$task->submit_file?>" target="_blank">文件下载</a>
                    </el-form-item>
                <?php endif;?>

                <?php if(!empty($model->submit_audio)):?>
                    <el-form-item label="提交音频">
                        <a type="button" class="btn btn-primary btn-flat" href="<?=$task->submit_audio?>" target="_blank">文件下载</a>
                    </el-form-item>
                <?php endif;?>

                <?php ActiveElementForm::end(); ?>

            </lte-box>
            <lte-box title="导师回复" icon="fa fa-edit">

                <div class="task-submit-form">

                    <?php ActiveElementForm::begin(["options"=>[
                        "label-width" => "100px",
                        "status-icon" => true,
                    ]]); ?>

                    <el-form-item prop="reply_content"
                                  label="<?= ActiveElementForm::getFieldLabel($model,"reply_content")?>"
                                  error="<?= ActiveElementForm::getFieldError($model,"reply_content")?>">
                        <el-input v-model="data.reply_content" type="textarea" rows="6"></el-input>
                    </el-form-item>

                    <el-form-item prop="reply_file"
                                  label="<?= ActiveElementForm::getFieldLabel($model,"reply_file")?>"
                                  error="<?= ActiveElementForm::getFieldError($model,"reply_file")?>">
                        <upload-file v-model="data.reply_file" path="taskSubmit"></upload-file>
                    </el-form-item>

                    <el-form-item prop="reply_audio"
                                  label="<?= ActiveElementForm::getFieldLabel($model,"reply_audio")?>"
                                  error="<?= ActiveElementForm::getFieldError($model,"reply_audio")?>">
                        <upload-file v-model="data.reply_audio" path="taskSubmit"></upload-file>
                    </el-form-item>

                    <el-form-item>
                        <lte-btn type="info" @click="submit"><i class="glyphicon glyphicon-floppy-disk"></i> 提交</lte-btn>
                        <lte-btn type="default" @click="back"><i class="glyphicon glyphicon-share-alt"></i> 返回</lte-btn>
                    </el-form-item>

                    <?php ActiveElementForm::end(); ?>

                </div>

            </lte-box>
        </lte-col>
    </lte-row>
</div>

<script>
    new Vue({
        el:'#app',
        data:{
            data:data
        },
        methods: {
            submit: function (event) {
                YiiFormSubmit(this.data, "TaskSubmit");
            },
            back:function(){
                history.go(-1);
            }
        }
    })
</script>
