<?php

use yii\helpers\Url;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\media\Pronunciation */

$this->title = '添加单词';
$this->params['small'] = 'Create';
$this->params['breadcrumbs'][] = ['label' => '发音词库', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

vuelte\tools\VarConvert::run($this, $model, "data");
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
                <?= Html::tag("lte-btn","<i class='glyphicon glyphicon-share-alt'></i> 返回",[
                "href"=>"javascript:history.go(-1)",
                "a"=>true,
                "block"=>true,
                "type"=>"warning"
                ])?>
            </lte-box>
        </lte-col>
        <lte-col col="9">
            <lte-box title="新增" icon="fa fa-plus">

                <?= $this->render('_form', [
                'model' => $model,
                ]) ?>

            </lte-box>
        </lte-col>
    </lte-row>
</div>

<script>
    new Vue({
        el:'#app',
        data:{
            data:data,
            showMessage:false,
        },
        methods:{
            submit:function(event){
                YiiFormSubmit(this.data,"<?= $model->formName()?>");
            },
            upload:function(res, file){
                if(res.state.code == 0 && res.data){
                    //设置属性
                    this.data.audio = res.data;
                    this.data = Object.assign({}, this.data);

                    //音频重新加载
                    var audio=document.getElementById("audio");
                    audio.load();
                }
            }
        }
    })
</script>
