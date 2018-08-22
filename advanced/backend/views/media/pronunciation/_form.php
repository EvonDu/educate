<?php

use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

vuelte\assets\PluginComponentsAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\media\Pronunciation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pronunciation-form">

    <?php $form = ActiveElementForm::begin(["options"=>[
        "label-width" => "100px",
        "status-icon" => true,
    ]]); ?>

    <?= $form->field($model, 'word')->el_input(['v-model' => 'data.word', 'maxlength' => true]) ?>

    <?= $form->field($model, 'audio')->el_upload([
            'content' => Html::tag("lte-btn","上传音频",["type" => "info"]),
            'show'=>'<audio id="audio" controls="controls" v-show="data.audio"><source :src="data.audio" type="audio/ogg">您的浏览器不支持 audio 元素</audio>',
            'action' => \yii\helpers\Url::to(["upload/qiniu",'src'=>''],true),
            ':on-success' => "upload",
            ':show-file-list' => "false"
    ]) ?>

    <el-form-item>
        <?= Html::tag("lte-btn","<i class='glyphicon glyphicon-floppy-disk'></i> 保存",["type" => "info", "@click" => "submit"]) ?>
    </el-form-item>

    <?php ActiveElementForm::end(); ?>

</div>

