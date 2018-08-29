<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vuelte\widgets\ActiveElementForm;

vuelte\assets\PluginComponentsAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\course\CourseLessonSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-lesson-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'course_id') ?>

    <?= $form->field($model, 'lesson') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'abstract') ?>

    <?php // echo $form->field($model, 'video') ?>

    <?php // echo $form->field($model, 'doc') ?>

    <?php // echo $form->field($model, 'is_public')->checkbox() ?>

    <?php // echo $form->field($model, 'is_homework')->checkbox() ?>

    <div class="form-group">
        <?= Html::tag("lte-btn","<i class='glyphicon glyphicon-search'></i> 搜索",["type" => "info", "submit" => true]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

