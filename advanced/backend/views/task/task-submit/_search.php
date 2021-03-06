<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vuelte\widgets\ActiveElementForm;

/* @var $this yii\web\View */
/* @var $model common\models\task\TaskSubmitSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-submit-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'task_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'submit_content') ?>

    <?= $form->field($model, 'submit_file') ?>

    <?php // echo $form->field($model, 'submit_audio') ?>

    <?php // echo $form->field($model, 'reply_content') ?>

    <?php // echo $form->field($model, 'reply_file') ?>

    <?php // echo $form->field($model, 'reply_audio') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'submit_at') ?>

    <?php // echo $form->field($model, 'reply_at') ?>

    <div class="form-group">
        <?= Html::tag("lte-btn","<i class='glyphicon glyphicon-search'></i> 搜索",["type" => "info", "submit" => true]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
