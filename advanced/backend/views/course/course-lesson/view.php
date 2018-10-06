<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\course\CourseLesson */

$this->title = $model->title;
$this->params['small'] = 'View';
$this->params['breadcrumbs'][] = ['label' => '课程管理', 'url' => Url::to(["course/course"])];
$this->params['breadcrumbs'][] = ['label' => $model->course->name, 'url' => Url::to(["course/course/view","id"=>$model->course_id])];
$this->params['breadcrumbs'][] = ['label' => '课程章节', 'url' => ['list',"course_id"=>$model->course_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="app">
    <lte-row>
        <lte-col col="3">
            <lte-box title="选项" icon="fa fa-edit">
                <?= Html::tag("lte-btn","<i class='glyphicon glyphicon-list'></i> 章节",[
                    "href"=>Url::to(["list","course_id"=>$model->course_id]),
                    "a"=>true,
                    "block"=>true,
                ])?>
                <?= Html::tag("lte-btn","<i class='glyphicon glyphicon-plus'></i> 添加",[
                    "href"=>Url::to(["create","course_id"=>$model->course_id]),
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

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        [
                            "label"=>"课程",
                            "attribute"=>'course.name',
                        ],
                        'lesson',
                        'title',
                        'abstract:raw',
                        'is_public:boolean',
                        [
                            'attribute'=>'video',
                            'format' => 'raw',
                            'value' => function($model){
                                if(isset($model->video)){
                                    $source = HTML::tag("source",'',["src"=>$model->video]);
                                    return HTML::tag("video",$source,["style"=>"max-width: 100%;width: 500px;"]);
                                }
                                else{
                                    return null;
                                }
                            }
                        ],
                        'content:ntext',
                        'task:raw',
                    ],
                ]) ?>

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