<?php

use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

/* @var $this yii\web\View */
/* @var $model common\models\user\UserFavorite */
/* @var $form yii\widgets\ActiveForm */
?>
<component-template>
    <div class="user-favorite-form">

        <?php ActiveElementForm::begin(["options"=>[
            "label-width" => "100px",
            "status-icon" => true,
        ]]); ?>

        <el-form-item prop="user_id"
                      label="<?= ActiveElementForm::getFieldLabel($model,"user_id")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"user_id")?>">
            <el-input v-model="data.user_id"></el-input>
        </el-form-item> 

        <el-form-item prop="course_id"
                      label="<?= ActiveElementForm::getFieldLabel($model,"course_id")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"course_id")?>">
            <el-input v-model="data.course_id"></el-input>
        </el-form-item> 

        <el-form-item prop="created_at"
                      label="<?= ActiveElementForm::getFieldLabel($model,"created_at")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"created_at")?>">
            <el-input v-model="data.created_at"></el-input>
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
                YiiFormSubmit(this.data, "UserFavorite");
            }
        }
    });
</script>

