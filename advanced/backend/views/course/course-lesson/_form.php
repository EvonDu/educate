<?php

use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

vuelte\assets\PluginComponentsAsset::register($this);
print $this->render('@app/views/components/upload-file');
print $this->render('@app/views/components/upload-video');

/* @var $this yii\web\View */
/* @var $model common\models\course\CourseLesson */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $template = function($model){ ?>
<div class="course-lesson-form">

    <?php ActiveElementForm::begin(["options"=>[
        "label-width" => "100px",
        "status-icon" => true,
    ]]); ?>

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

    <el-form-item prop="video"
                  label="<?= ActiveElementForm::getFieldLabel($model,"video")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"video")?>">
        <upload-video v-model="data.video"></upload-video>
    </el-form-item> 

    <el-form-item prop="doc"
                  label="<?= ActiveElementForm::getFieldLabel($model,"doc")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"doc")?>">
        <upload-file v-model="data.doc"></upload-file>
    </el-form-item> 

    <el-form-item prop="is_public"
                  label="<?= ActiveElementForm::getFieldLabel($model,"is_public")?>"
                  error='<?= ActiveElementForm::getFieldError($model,"is_public")?>'>
        <el-switch v-model="data.is_public" active-value="1" inactive-value="0"></el-switch>
    </el-form-item>

    <el-form-item>
        <lte-btn type="info" @click="submit"><i class='glyphicon glyphicon-floppy-disk'></i> 保存</lte-btn>
    </el-form-item>

    <?php ActiveElementForm::end(); ?>

</div>
<?php  }?>

<script>
    Vue.component('model-form', {
        template: `<?= $template($model); ?>`,
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


