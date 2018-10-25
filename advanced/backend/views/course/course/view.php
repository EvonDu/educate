<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\course\Course */

$this->title = $model->name;
$this->params['small'] = 'View';
$this->params['breadcrumbs'][] = ['label' => '课程管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
                <?= Html::tag("lte-btn","<i class='glyphicon glyphicon-edit'></i> 修改",[
                    "href"=>Url::to(["update", 'id' => $model->id]),
                    "a"=>true,
                    "block"=>true,
                    "type"=>"success"
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
            <lte-box title="详情" icon="fa fa-eye">
                <el-tabs value="base">
                    <el-tab-pane label="课程信息" name="base">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'id',
                                'num',
                                'instructor.name',
                                'type.name',
                                'name',
                                [
                                    'attribute'=>'image',
                                    'format' => 'raw',
                                    'value' => function($model){return Html::img($model->image,['style'=>'width: 100px;']);}
                                ],
                                'level',
                                'synopsis:ntext',
                                'abstract:raw',
                                'created_at:datetime',
                                'updated_at:datetime',
                            ],
                        ]) ?>
                    </el-tab-pane>
                    <el-tab-pane label="课程要求" name="requirements">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'requirements_prerequisites:raw',
                                'requirements_textbooks:raw',
                                'requirements_software:raw',
                                'requirements_hardware:raw',
                            ],
                        ]) ?>
                    </el-tab-pane>
                    <el-tab-pane label="课程收费" name="price">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                [
                                    'attribute'=>'price',
                                    'value' => function($model){return isset($model->price)?$model->price/100:0;}
                                ],
                                'try:boolean'
                            ],
                        ]) ?>
                    </el-tab-pane>
                    <el-tab-pane label="其他信息" name="other">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'next_term_at:datetime',
                            ],
                        ]) ?>
                    </el-tab-pane>
                </el-tabs>
            </lte-box>
        </lte-col>
    </lte-row>
</div>

<script>
    new Vue({
        el:'#app',
        data:{}
    })
</script>