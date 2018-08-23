<?php

use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

vuelte\assets\PluginComponentsAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\teacher\Teacher */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .el-tag{
        margin-right: 10px;
    }
    .button-new-tag {
        margin-right: 10px;
        height: 32px;
        line-height: 30px;
        padding-top: 0;
        padding-bottom: 0;
    }
    .input-new-tag {
        width: 90px;
        margin-left: 10px;
        vertical-align: bottom;
    }
</style>
<?php  function template($model){ ?>
<div class="teacher-form">

    <?php ActiveElementForm::begin(["options"=>[
        "label-width" => "100px",
        "status-icon" => true,
    ]]); ?>

    <el-form-item prop="name"
        label="<?= ActiveElementForm::getFieldLabel($model,"name")?>"
        error="<?= ActiveElementForm::getFieldError($model,"name")?>">
        <el-input v-model="data.name"></el-input>
    </el-form-item> 

    <el-form-item prop="title"
        label="<?= ActiveElementForm::getFieldLabel($model,"title")?>"
        error="<?= ActiveElementForm::getFieldError($model,"title")?>">
        <el-input v-model="data.title"></el-input>
    </el-form-item>

    <el-form-item prop="tags"
        label="<?= ActiveElementForm::getFieldLabel($model,"tags")?>"
        error="<?= ActiveElementForm::getFieldError($model,"tags")?>">
        <el-tag
                :key="tag"
                v-for="tag in dynamicTags"
                closable
                :disable-transitions="false"
                @close="handleClose(tag)">
            {{tag}}
        </el-tag>
        <el-input
                class="input-new-tag"
                v-if="inputVisible"
                v-model="inputValue"
                ref="saveTagInput"
                size="small"
                @keyup.enter.native="handleInputConfirm"
                @blur="handleInputConfirm">
        </el-input>
        <el-button v-else class="button-new-tag" size="small" @click="showInput">+ New Tag</el-button>
    </el-form-item>

    <el-form-item prop="abstract"
                  label="<?= ActiveElementForm::getFieldLabel($model,"abstract")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"abstract")?>">
        <summernote v-model="data.abstract"></summernote>
    </el-form-item>

    <el-form-item>
        <lte-btn type="info" @click="submit"><i class='glyphicon glyphicon-floppy-disk'></i> 保存</lte-btn>
    </el-form-item>

    <?php ActiveElementForm::end(); ?>
</div>
<?php  }?>

<script>
    Vue.component('model-form', {
        template: `<?= template($model); ?>`,
        props:{
            'data':{ type: Object, default: function(){ return {}; }}
        },
        data:function(){
            return {
                dynamicTags: [],
                inputVisible: false,
                inputValue: ''
            }
        },
        created:function(){
            this.dynamicTags = this.data.tags ? this.data.tags.split(",") : [];
        },
        methods: {
            submit: function (event) {
                this.data.tags = this.dynamicTags.join(",");
                YiiFormSubmit(this.data, "Teacher");
            },
            //tags相关方法
            handleClose:function(tag) {
                this.dynamicTags.splice(this.dynamicTags.indexOf(tag), 1);
            },
            showInput:function() {
                this.inputVisible = true;
                var _this  = this;
                this.$nextTick(function(){
                    return _this.$refs.saveTagInput.$refs.input.focus();
                });
            },
            handleInputConfirm:function() {
                var inputValue = this.inputValue;
                if (inputValue) {
                    this.dynamicTags.push(inputValue);
                }
                this.inputVisible = false;
                this.inputValue = '';
            }
        }
    });
</script>


