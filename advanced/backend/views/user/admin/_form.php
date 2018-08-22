<?php

use yii\helpers\Html;
use vuelte\widgets\ActiveElementForm;

vuelte\assets\PluginComponentsAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\user\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveElementForm::begin(["options"=>[
        "label-width" => "100px",
        "status-icon" => true,
    ]]); ?>

    <?= $form->field($model, 'status')->el_input(['v-model' => 'data.status', 'type' => 'input']) ?>

    <el-form-item>
        <?= Html::tag("lte-btn","<i class='glyphicon glyphicon-floppy-disk'></i> 保存",["type" => "info" ,"@click" => "submit"]) ?>
    </el-form-item>

    <?php ActiveElementForm::end(); ?>

</div>

