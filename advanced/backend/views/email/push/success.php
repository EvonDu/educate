<?php

use vuelte\widgets\ActiveElementForm;

/* @var $this yii\web\View */
/* @var $model common\models\page\Page */

$this->title = '发送完毕';
$this->params['small'] = 'Email';
?>
<div id="app">
    <el-alert
            title="发送成功"
            type="success"
            description="邮件已经成功推送给所有用户."
            show-icon
            effect="dark">
    </el-alert>
</div>

<script>
    new Vue({
        el:'#app'
    })
</script>
