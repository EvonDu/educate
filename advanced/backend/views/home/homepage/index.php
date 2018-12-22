<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\page\Page */

$this->title = '主页设置';
$this->params['small'] = 'Homepage';
$this->params['breadcrumbs'][] = $model->title;

vuelte\lib\Import::value($this, $model, "model");
vuelte\lib\Import::component($this,'_form', ['model' => $model]);
?>
<div id="app">
    <lte-row>
        <lte-col>
            <lte-box title="内容设置" icon="fa fa-edit">

                <model-form :data="model"></model-form>

            </lte-box>
        </lte-col>
    </lte-row>
</div>


<script>
    new Vue({
        el:'#app',
        data:{
            model:model,
        }
    })
</script>
