<?php

use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

/* @var $this yii\web\View */
/* @var $model common\models\course\CourseType */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $template = function($model){ ?>
<div class="course-type-form">

    <?php ActiveElementForm::begin(["options"=>[
        "label-width" => "100px",
        "status-icon" => true,
    ]]); ?>

    <el-form-item prop="name"
                  label="<?= ActiveElementForm::getFieldLabel($model,"name")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"name")?>">
        <el-input v-model="data.name"></el-input>
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
                YiiFormSubmit(this.data, "CourseType");
            }
        }
    });
</script>


