<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\user\UserCourse */

$this->title = 'Update User Course: {nameAttribute}';
$this->params['small'] = 'Update';
$this->params['breadcrumbs'][] = ['label' => 'User Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_id, 'url' => ['view', 'user_id' => $model->user_id, 'course_id' => $model->course_id]];
$this->params['breadcrumbs'][] = 'Update';

vuelte\lib\Import::value($this, $model, "data");
vuelte\lib\Import::component($this,'_form', ['model' => $model]);
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
                    "href"=>Url::to(["create"]),
                    "a"=>true,
                    "block"=>true,
                    "type"=>"info"
                ])?>
                <?= Html::tag("lte-btn","<i class='glyphicon glyphicon-remove'></i> 删除",[
                    "href"=>Url::to(["delete", 'user_id' => $model->user_id, 'course_id' => $model->course_id]),
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

                <model-form :data="data"></model-form>

            </lte-box>
        </lte-col>
    </lte-row>
</div>

<script>
    new Vue({
        el:'#app',
        data:{
            data:data
        }
    })
</script>