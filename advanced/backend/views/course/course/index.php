<?php

use yii\helpers\Url;
use yii\helpers\Html;
use vuelte\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\course\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '课程管理';
$this->params['small'] = 'List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="app">
    <lte-row>
        <lte-col col="3">
            <lte-box title="选项" icon="fa fa-edit">
                <?= Html::tag("lte-btn","<i class='glyphicon glyphicon-plus'></i> 添加",[
                    "href"=>Url::to(["create"]),
                    "a"=>true,
                    "block"=>true,
                    "type"=>"info"
                ])?>
                <?= Html::tag("lte-btn","<i class='glyphicon glyphicon-share-alt'></i> 返回",[
                    "href"=>"javascript:history.go(-1)",
                    "a"=>true,
                    "block"=>true,
                    "type"=>"warning"
                ])?>
            </lte-box>
            <lte-box title="搜索" icon="fa fa-search">
                <?= $this->render('_search', ['model' => $searchModel]); ?>
            </lte-box>
        </lte-col>
        <lte-col col="9">
            <lte-box title="列表" icon="fa fa-list">

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'id',
                        'num',
                        'name',
                        'name_en',
                        'instructor.name',
                        //'synopsis:ntext',
                        //'image',
                        //'level',
                        //'abstract:ntext',
                        //'content:ntext',
                        //'requirements_prerequisites:ntext',
                        //'requirements_textbooks:ntext',
                        //'requirements_software:ntext',
                        //'requirements_hardware:ntext',
                        //'next_term_at',
                        //'created_at',
                        //'updated_at',

                        [
                            'class' => 'vuelte\widgets\ActionColumn',
                            'template' => '{view} {update} {delete} {lesson}',
                            'buttons' => [
                                'lesson' => function ($url, $model, $key) {
                                    $options = array_merge([
                                        'title' => '章节',
                                        'aria-label' => '章节',
                                        'data-pjax' => '0',
                                        'type'=> 'warning',
                                        'size'=> 'xs',
                                        'href'=> Url::to(["course/course-lesson/list","course_id"=>$model->id]),
                                        'a'=>true,
                                    ]);
                                    $content = " <i class='glyphicon glyphicon-book'></i> 章节";
                                    return Html::tag("lte-btn",$content, $options);
                                },
                                'assign' => function ($url, $model, $key) {
                                    $options = array_merge([
                                        'title' => '角色',
                                        'aria-label' => '角色',
                                        'data-pjax' => '0',
                                        'type'=> 'warning',
                                        'size'=> 'xs',
                                        'href'=> $url,
                                        'a'=>true,
                                    ]);
                                    $content = " <i class='glyphicon glyphicon-user'></i> 角色";
                                    return Html::tag("lte-btn",$content, $options);
                                },
                            ],
                        ],
                    ],
                ]); ?>

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
