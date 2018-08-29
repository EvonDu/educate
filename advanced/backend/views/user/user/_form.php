<?php

use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

print $this->render('@app/views/components/avatar');

/* @var $this yii\web\View */
/* @var $model common\models\user\User */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $template = function($model){ ?>
<div class="user-form">

    <?php ActiveElementForm::begin(["options"=>[
        "label-width" => "100px",
        "status-icon" => true,
    ]]); ?>

    <el-form-item prop="email"
                  label="<?= ActiveElementForm::getFieldLabel($model,"email")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"email")?>">
        <el-input v-model="data.email"></el-input>
    </el-form-item>

    <el-form-item prop="firstname"
                  label="<?= ActiveElementForm::getFieldLabel($model,"firstname")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"firstname")?>">
        <el-input v-model="data.firstname"></el-input>
    </el-form-item> 

    <el-form-item prop="lastname"
                  label="<?= ActiveElementForm::getFieldLabel($model,"lastname")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"lastname")?>">
        <el-input v-model="data.lastname"></el-input>
    </el-form-item> 

    <el-form-item prop="avatar"
                  label="<?= ActiveElementForm::getFieldLabel($model,"avatar")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"avatar")?>">
        <avatar v-model="data.avatar"></avatar>
    </el-form-item> 

    <el-form-item prop="phone"
                  label="<?= ActiveElementForm::getFieldLabel($model,"phone")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"phone")?>">
        <el-input v-model="data.phone"></el-input>
    </el-form-item> 

    <el-form-item prop="country"
                  label="<?= ActiveElementForm::getFieldLabel($model,"country")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"country")?>">
        <el-input v-model="data.country"></el-input>
    </el-form-item> 

    <el-form-item prop="city"
                  label="<?= ActiveElementForm::getFieldLabel($model,"city")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"city")?>">
        <el-input v-model="data.city"></el-input>
    </el-form-item> 

    <el-form-item prop="adderss_1"
                  label="<?= ActiveElementForm::getFieldLabel($model,"adderss_1")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"adderss_1")?>">
        <el-input v-model="data.adderss_1"></el-input>
    </el-form-item> 

    <el-form-item prop="adderss_2"
                  label="<?= ActiveElementForm::getFieldLabel($model,"adderss_2")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"adderss_2")?>">
        <el-input v-model="data.adderss_2"></el-input>
    </el-form-item>

    <el-form-item prop="status"
                  label="<?= ActiveElementForm::getFieldLabel($model,"status")?>"
                  error="<?= ActiveElementForm::getFieldError($model,"status")?>">
        <el-select v-model="data.status" placeholder="请选择">
            <el-option
                    v-for="(item,index) in statusMap"
                    :key="index"
                    :label="item"
                    :value="parseInt(index)">
            </el-option>
        </el-select>
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
            data:{ type: Object, default: function(){ return {}; }},
        },
        data:function(){
            return {
                statusMap:<?=json_encode(\common\models\user\User::getStatusMap()) ?>
            }
        },
        methods: {
            submit: function (event) {
                YiiFormSubmit(this.data, "User");
            }
        }
    });
</script>


