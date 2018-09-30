<?php

use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

/* @var $this yii\web\View */
/* @var $model common\models\admin\Admin */
/* @var $form yii\widgets\ActiveForm */
?>

<component-template>
    <div class="admin-form">

        <?php ActiveElementForm::begin(["options"=>[
            "label-width" => "100px",
            "status-icon" => true,
        ]]); ?>

        <el-form-item prop="status"
                      label="<?= ActiveElementForm::getFieldLabel($model,"status")?>"
                      error="<?= ActiveElementForm::getFieldError($model,"status")?>">
            <el-input v-model="data.status"></el-input>
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
            'data':{ type: Object, default: function(){ return {}; }}
        },
        methods: {
            submit: function (event) {
                YiiFormSubmit(this.data, "Admin");
            }
        }
    });
</script>


