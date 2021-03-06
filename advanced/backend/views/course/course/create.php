<?php

use yii\helpers\Url;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\course\Course */

$this->title = '添加课程';
$this->params['small'] = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

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
