<?php

use yii\helpers\Url;
use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

/* @var $this yii\web\View */
/* @var $model common\models\admin\AdminInfo */

$this->title = "更新: $model->nickname";
$this->params['small'] = 'Info';
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nickname, 'url' => ['view', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = '更新';

vuelte\lib\Import::value($this, $model, "data");
vuelte\lib\Import::component($this,'@app/views/components/avatar');
?>
<div id="app">
    <lte-row>
        <lte-col col="3">
            <lte-box title="选项" icon="fa fa-edit">
                <?= Html::tag("lte-btn","<i class='glyphicon glyphicon-list'></i> 列表",[
                    "href"=>Url::to(["index"]),
                    "a"=>true,
                    "block"=>true,
                ])?>
                <?= Html::tag("lte-btn","<i class='glyphicon glyphicon-plus'></i> 添加",[
                    "href"=>Url::to(["signup"]),
                    "a"=>true,
                    "block"=>true,
                    "type"=>"info"
                ])?>
                <?= Html::tag("lte-btn","<i class='glyphicon glyphicon-remove'></i> 删除",[
                    "href"=>Url::to(["delete", 'id' => $model->id]),
                    "a"=>true,
                    "block"=>true,
                    "type"=>"danger",
                    'data' => [
                        'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ]
                ])?>
                <?= Html::tag("lte-btn","<i class='glyphicon glyphicon-share-alt'></i> 返回",[
                    "href"=>"javascript:history.go(-1)",
                    "a"=>true,
                    "block"=>true,
                    "type"=>"warning"
                ])?>
            </lte-box>
        </lte-col>
        <lte-col col="9">
            <lte-box title="编辑" icon="fa fa-edit">

                <?php ActiveElementForm::begin(["options"=>[
                    "label-width" => "100px",
                    "status-icon" => true,
                ]]); ?>

                <el-form-item prop="avatar"
                              label="<?= ActiveElementForm::getFieldLabel($model,"avatar")?>"
                              error="<?= ActiveElementForm::getFieldError($model,"avatar")?>">
                    <avatar v-model="data.avatar"></avatar>
                </el-form-item>

                <el-form-item prop="nickname"
                              label="<?= ActiveElementForm::getFieldLabel($model,"nickname")?>"
                              error="<?= ActiveElementForm::getFieldError($model,"nickname")?>">
                    <el-input v-model="data.nickname"></el-input>
                </el-form-item>

                <el-form-item>
                    <lte-btn type="info" @click="submit"><i class='glyphicon glyphicon-floppy-disk'></i> 保存</lte-btn>
                </el-form-item>

                <?php ActiveElementForm::end(); ?>


            </lte-box>
        </lte-col>
    </lte-row>
</div>

<script>
    new Vue({
        el:'#app',
        data:{
            data:data,
        },
        computed:{
            imageUrl:function(){
                if(this.data.avatar)
                    return '<?= Url::to(['upload/get','src' => ''],true)?>' + this.data.avatar;
                else
                    return null;
            }
        },
        methods:{
            upload:function(res, file) {
                if(res.state.code == 0 && res.data)
                    this.data.avatar = res.data;
                else
                    this.data.avatar = URL.createObjectURL(file.raw);
                this.data = Object.assign({}, this.data);
            },
            submit:function(event){
                YiiFormSubmit(this.data,"<?= $model->formName()?>");
            },
        }
    })
</script>