<?php

use vuelte\widgets\ActiveElementForm;

/* @var $this yii\web\View */
/* @var $model common\models\page\Page */

$this->title = '邮件推送';
$this->params['small'] = 'Email';

vuelte\lib\Import::value($this, $model, "model");
vuelte\lib\Import::component($this,"@app/views/components/ueditor");
?>
<div id="app">
    <lte-row>
        <lte-col>
            <lte-box title="邮件编写" icon="fa fa-edit">

                <div class="page-form">

                    <?php ActiveElementForm::begin(["options"=>[
                        "label-width" => "100px",
                        "status-icon" => true,
                    ]]); ?>

                    <el-form-item prop="content"
                                  label="<?= ActiveElementForm::getFieldLabel($model,"content")?>"
                                  error="<?= ActiveElementForm::getFieldError($model,"content")?>">
                        <ueditor v-model="model.content"></ueditor>
                    </el-form-item>

                    <el-form-item>
                        <lte-btn type="info" @click="submit"><i class="glyphicon glyphicon-envelope"></i> 立刻发送</lte-btn>
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
            model:model,
        },
        methods: {
            submit: function (event) {
                YiiFormSubmit(this.model,"<?=$model->formName()?>");
            }
        }
    })
</script>
